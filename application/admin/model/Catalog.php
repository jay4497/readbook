<?php

namespace app\admin\model;

use think\Model;


class Catalog extends Model
{
    // 表名
    protected $name = 'catalog';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'book_title',
        'parent_title',
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $weigh = $row->weigh;
            if (empty($weigh)) {
                $pk = $row->getPk();
                $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
            }
        });
    }

    public function getBookTitleAttr($val, $data)
    {
        $val = $val?: $data['book_id'];
        $book = \think\Db::name('book')
            ->where('id', $val)
            ->find();
        if(empty($book)) {
            return '';
        }
        return $book['title'];
    }

    public function getParentTitleAttr($val, $data)
    {
        $val = $val?: $data['parent_id'];
        $parent = $this
            ->where('id', $val)
            ->find();
        if(empty($parent)) {
            return '';
        }
        return $parent['title'];
    }

    public function getCatalogChain($id)
    {
        $title = '';
        $catalog = $this
            ->where('id', $id)
            ->find();
        if(empty($catalog)) {
            return '';
        }
        $title = $catalog['title'];
        if($catalog['parent_id'] > 0) {
            $title .= '/'. $this->getCatalogChain($catalog['parent_id']);
        }
        return $title;
    }

}
