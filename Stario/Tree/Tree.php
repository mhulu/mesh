<?php 

use Illuminate\Database\Eloquent\Collection;

namespace Star\Tree;

class Tree extends Collection
{
    public function buildTree()
    {
        $structure = $this->matchNodes();
        $this->clean($structure);
        return $structure;
    }
}
