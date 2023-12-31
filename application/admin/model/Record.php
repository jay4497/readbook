<?php

namespace app\admin\model;

use think\Model;


class Record extends Model
{
    // 表名
    protected $name = 'record';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'content_title'
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

    public function getContentTitle($val, $data)
    {
        $val = $val?: $data['content_id'];
        $content = \think\Db::name('content')
            ->where('id', $val)
            ->find();
        if(empty($content)) {
            return '';
        }
        return $content['title'];
    }

}
