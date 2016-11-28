<?php
namespace mycone\users\models;

use Yii;

class Depts extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%depts}}';
    }
    
    /**
     * 获取分类树
     * @param array $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param number $root
     * @return multitype:unknown
     */
    public static function list_to_tree($list=[], $pk = 'id', $pid = 'root', $child = '_child', $root = 0) {
        $list = empty($list) ? static::find()->select(['id','root','name'])->asArray()->all() : $list;
        // 创建Tree
        $tree = [];
        if (is_array ( $list )) {
            // 创建基于主键的数组引用
            $refer = [];
            foreach ( $list as $key => $data ) {
                $refer [$data [$pk]] = & $list [$key];
            }
            foreach ( $list as $key => $data ) {
                // 判断是否存在parent
                $parentId = $data [$pid];
                if($data[$pid]==$data[$pk]) {
                //if ($root == $parentId) {
                    //$tree[] =& $list[$key];
                    $tree[$data[$pk]] =& $list[$key]; //使用pk作为key
                } else {
                    if (isset ( $refer [$parentId] )) {
                        $parent = & $refer [$parentId];
                        //$parent[$child][] =& $list[$key];
                        $parent[$child][$data[$pk]] =& $list[$key]; //使用pk作为key
                    }
                }
            }
        }
        return $tree;
    }
    
}