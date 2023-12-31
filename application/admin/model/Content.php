<?php

namespace app\admin\model;

use think\Model;


class Content extends Model
{
    // 表名
    protected $name = 'content';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'book_title',
        'catalog_title',
        'catalog_breadcrumb',
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $weigh = $row->weigh;
            if(empty($weigh)) {
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

    public function getCatalogTitleAttr($val, $data)
    {
        $val = $val?: $data['catalog_id'];
        $catalog = \think\Db::name('catalog')
            ->where('id', $val)
            ->find();
        if (empty($catalog)) {
            return '';
        }
        return $catalog['title'];
    }

    public function getCatalogBreadcrumbAttr($val, $data)
    {
        $val = $val?: $data['catalog_id'];
        $model = new Catalog;
        $catalog = $model->getCatalogChain($val);
        if(empty($catalog)) {
            return '';
        }
        $segments = array_filter(explode('/', $catalog));
        $new_segments = array_reverse($segments);
        return implode(' / ', $new_segments);
    }

}
