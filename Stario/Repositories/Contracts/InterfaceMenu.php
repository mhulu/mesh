<?php 
namespace Star\Repositories\Contracts;

interface InterfaceMenu
{
        // public function all($orderBy = 'id', $order = 'desc');
        // public function find();
        public function tree($parent_id = 0);
}
