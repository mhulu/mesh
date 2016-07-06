<?php 
namespace Star\Repositories\Eloquent;

use App\App;
use App\User;
use App\Wxmp;
use Carbon\Carbon;
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
        return $messages->map(function ($item) {
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
        return $this->user->wxmps()->get();
    }
    /**
     * 当前用户是否关联了某个公众号
     * @param  [type]  $wxmp_id [description]
     * @return boolean          [description]
     */
    public function hasWxmp($wxmp_id)
    {
        return \DB::table('user_wxmp')
                                ->whereUserId($this->user->id)
                                ->whereWxmpId($wxmp_id)
                                ->count() > 0;
    }

    public function findMpBy($field)
    {
        
    }

    public function detachWxmp($wxmp_id)
    {
        return $this->user->wxmps()->detach($wxmp_id);
    }

    public function attachWxmp($wxmp_id)
    {
        return $this->user->wxmps()->attach($wxmp_id);
    }

    public function deleteWxmp($id)
    {
        return Wxmp::destroy($id);
    }

    /**
     * 将传递来的数据择入数据库
     * @param  [type] $wxData 微信返回的原始数据
     * @return [type]         [description]
     */
    public function bindMp($wxData)
    {
        $appId = $wxData->authorization_info->authorizer_appid;
        $wxInfo = WeOpen::fetchInfo($appId);
        $token = $wxData->authorization_info->authorizer_access_token;
        $refreshToken = $wxData->authorization_info->authorizer_refresh_token;
        $expires = $wxData->authorization_info->expires_in;
        $wxmp = new WxmpRepo();
        //如果库里没有该公众号则创建并关联user_wxmp
        if (!$wxmp->has('appId', $appId)) {
            return $this->user->wxmps()->create([
                        'appId' => $appId,
                        'name' => $wxInfo->authorizer_info->user_name,
                        'nickname' => $wxInfo->authorizer_info->nick_name,
                        'authorized' => true,
                        'avatar_url' => $wxInfo->authorizer_info->head_img,
                        'qr_url' => $wxInfo->authorizer_info->qrcode_url,
                        'token' => $token,
                        'refresh_token' => $refreshToken,
                        'expires' => Carbon::now()->addSeconds($expires)
                    ]);
        } elseif (!$this->hasWxmp($wxmp->getId('appId', $appId))) {
            $this->attachWxmp($wxmp->getId('appId', $appId));
            return true;
        } else {
            return true;
        }
    }
    public function userInfo($wxmp_id)
    {
        // 这个是用户在wemesh中的角色,不是公众号的角色
        // $role_id = $this->user->roles->first()['id'];
        return response()->json([
            'name' =>empty($this->user->name) ? $this->user->mobile : $this->user->name,
            'avatar' => empty($this->user->avatar) ? 'http://static.stario.net/images/avatar.png' : $this->user->avatar,
            // 'role' =>$this->roles()->first()['label'],
            //在wemesh中的角色调用
            // 'permissions' => Role::find($role_id)->permissions,
            //在公众号中的角色
            'role' => $this->isTheFirstOneInWxmp($this->user->id, $wxmp_id) ? '公众号管理员' : '公众号运营者',
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
    public function isTheFirstOneInWxmp($user_id, $wxmp_id)
    {
        return Wxmp::find($wxmp_id)->users->first()->id == $user_id;
    }

    //判断当前用户是否是公众号管理者的最后一位
    public function isTheLastOneInWxmp($user_id, $wxmp_id)
    {
        $wxmp = Wxmp::find($wxmp_id);
        if (count($wxmp->users) == 1 && $wxmp->users->first()->id == $user_id) {
            return true;
        }
        return false;
    }
}
