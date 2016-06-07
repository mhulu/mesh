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
        $user = $this->user->find($uid);
        $appid = $wxData->authorization_info->authorizer_appid;
        $token = $wxData->authorizer_info->authorizer_access_token;
        $refreshToken = $wxData->authorizer_info->authorizer_refresh_token;
        $wxmp = new WxmpRepo;
        if ($wxmp->has($appId)) {
            echo "aaaaa";
        } else {
                $wxmp->create([
                        'appId' => $appId,
                        'token' => $token,
                        'refresh_token' => $refreshToken
                    ]);
        }
        $wxInfo = WeOpen::fetchInfo($appid);
    }

    public function userInfo($wxmp_id)
    {
        $role_id = $this->user->roles->first()['id'];
        return response()->json([
            'name' =>empty($this->user->name) ? $this->user->mobile : $this->user->name,
            'avatar' => $this->user->avatar,
            'role' =>$this->roles()->first()['label'],
            'permissions' => Role::find($role_id)->permissions,
            'apps' => $this->findApp($wxmp_id),
            'menu' => $this->menu($wxmp_id),
            'messages' => $this->messages()
            ], 200);
    }
}
