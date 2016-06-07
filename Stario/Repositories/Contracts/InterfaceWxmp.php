<?php 
namespace Star\Repositories\Contracts;

/**
 * 本接口用于微信公众号常用操作
 */
interface InterfaceWxmp
{
        public function has($appId); //数据库中是否该微信
        public function create($data);
        // public function updateWxmp($data);
}
