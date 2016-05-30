<?php 
namespace Star\Repositories\Contracts;

/**
 * 本接口用于用户登陆后获取资料
 * 即围绕Auth::user()展开查询
 */
interface InterfaceUser
{
        public function roles();
        public function permissions();
        public function messages();
        public function wxmps();
        public function menu($wxmp_id);
        public function bindMp($wxData);
        public function findMpBy($filed);
        public function findApp($wxmp_id);
        public function allApps();
        // public function bindApp($data);
        public function hasMobile($mobile); //数据库中是否有此手机号码
        public function saveUser($data);
        public function updateUser($data);
}
