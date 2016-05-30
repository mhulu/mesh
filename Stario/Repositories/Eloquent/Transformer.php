<?php 
namespace Star\Repositories\Eloquent;

use Illuminate\Support\Collection;

/**
 * 用于将数据库中的字段转换为可读性文字
 */
trait Transformer
{
    /**
     * 将字段中的数字(实为字符)转换为对应的文字
     * @param  string $origin      数据库中的字段值
     * @param  array  $destination 对应的文字数组
     * @return string              输出对应的文字
     */
    public function numToChar($origin, array $destination)
    {
        return $destination[intval($origin)];
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