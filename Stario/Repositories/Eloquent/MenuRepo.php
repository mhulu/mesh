<?php 
namespace Star\Repositories\Eloquent;

use App\Menu;
use App\User;
use App\Wxmp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Star\Repositories\Contracts\InterfaceMenu;
use Star\Repositories\Eloquent\UserRepo;

class MenuRepo implements InterfaceMenu
{
    
    public function tree($parent_id = 0)
    {
        // $menus = Menu::all();
        // return $this->buildTree($menus, $parent_id);
        $user = Auth::user();
        $wxmp_ids = $user->wxmps->lists('id'); //不是一个,是很多,需要遍历
        $data = [];
        foreach ($wxmp_ids as $item) {
            $data[] = Wxmp::find($item)->apps;
        };
        return $data;
    }

    private function buildTree(Collection $elements, $parent_id = 0)
    {
        $data = [];
        foreach ($elements as $element) {
            if ($element->parent_id == $parent_id) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->submenu = $children;
                }
                $data[] = $element;
            }
        }
        return $data;
    }
}
