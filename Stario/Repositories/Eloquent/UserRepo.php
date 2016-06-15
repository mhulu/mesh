<?php 
namespace Star\Repositories\Eloquent;

use App\App;
use App\User;
use App\Wxmp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Star\Permission\Models\Permission;
use Star\Permission\Models\Role;
use Star\Repositories\Contracts\InterfaceUser;
use Star\Repositories\Eloquent\Transformer;
use Star\Repositories\Eloquent\WxmpRepo;
use Star\wechat\WeOpen;


class UserRepo implements InterfaceUser
{
    use Transformer;
    protected $user;
    protected $transformer;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function roles()
    {
        return $this->user->roles;
    }

    public function findApp($wxmp_id)
    {
        return $this->user->wxmps->find($wxmp_id)->apps;
    }

/**
 * 用户购买的所有应用
 */
    public function allApps()
    {
        $wxmp_ids = $this->user->wxmps->lists('id');
        $data = new Collection;
        foreach ($wxmp_ids as $item) {
            $data->push(Wxmp::find($item)->apps);
        };
        return $data->unique('id')->flatten();
    }

    public function permissions()
    {
        $permission_id = $this->user->roles->first()['id'];
        return Permission::find($permission_id);
    }

    public function messages()
    {
        $messages = $this->user->messages;
        return $messages->map(function($item){
            return [
                'body' => $item->body,
                'type' => $this->numToChar($item->type, ['系统','用户','微信']),
                'read' => (bool)$item->read ? true : false
            ];
        });
    }

    public function menu($wxmp_id)
    {
        $ids = $this->findApp($wxmp_id)->lists('id');
        $data = new Collection;
        foreach ($ids as $id) {
            $data->push(App::find($id)->menus);
        }
        return $this->buildTree($data->flatten());
    }

    public function hasMobile($mobile)
    {
        return $this->user->where('mobile', $mobile)->first();
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function update($data)
    {
        return $this->user->where('mobile', $data['mobile'])->update(['password' => bcrypt($data['password'])]);
    }

    /**
     * 获取登陆用户全部的微信公众号列表
     * @param  [integer] $uid 用户id
     */
    public function wxmps()
    {
        $mps = $this->user->wxmps()->get();
        return $mps;
    }

    public function findMpBy($field)
    {
        
    }

    /**
     * 将传递来的数据择入数据库
     * @param  [type] $wxData 微信返回的原始数据
     * @return [type]         [description]
     */
    public function bindMp($wxData)
    {
        $appid = $wxData->authorization_info->authorizer_appid;
        $token = $wxData->authorizer_info->authorizer_access_token;
        $refreshToken = $wxData->authorizer_info->authorizer_refresh_token;
        $expires = $wxData->authorizer_info->expires_in;
        $wxmp = new WxmpRepo;
        if ($wxmp->has($appid)) {
            //如果数据库中已有改appid的微信号，直接返回
            return true;
        } else {
                $wxmp->create([
                        'appId' => $appId,
                        'token' => $token,
                        'refresh_token' => $refreshToken
                    ]);
        }
        $wxInfo = WeOpen::fetchInfo($appid);
        dd($wxInfo);
    }

    public function userInfo($wxmp_id)
    {
        // 这个是用户在wemesh中的角色
        // $role_id = $this->user->roles->first()['id']; 
        return response()->json([
            'name' =>empty($this->user->name) ? $this->user->mobile : $this->user->name,
            'avatar' => empty($this->user->avatar) ? 'http://static.stario.net/images/avatar.png' : $this->user->avatar,
            // 'role' =>$this->roles()->first()['label'],
            //在wemesh中的角色调用
            // 'permissions' => Role::find($role_id)->permissions,
            //在公众号中的角色
            'role' => $this->findWxmpAdmin($wxmp_id)->id == $this->user->id ? '公众号管理员' : '公众号运营者',
            'apps' => $this->findApp($wxmp_id),
            'menu' => $this->menu($wxmp_id),
            'messages' => $this->messages()
            ], 200);
    }
/**
 * 将微信公众号中绑定的第一个用户作为管理员
 * @param  [int] $wxmp_id 
 * @return App\User
 */
    private function findWxmpAdmin($wxmp_id)
    {
        return Wxmp::find($wxmp_id)->users->first();
    }
}
