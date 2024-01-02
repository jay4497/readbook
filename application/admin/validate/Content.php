<?php

namespace app\admin\validate;

use think\Validate;

class Content extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'book_id' => 'require',
        'catalog_id' => 'require',
        'title' => 'require'
    ];

    protected $field = [
        'book_id' => '书籍',
        'catalog_id' => '目录',
        'title' => '标题'
    ];

    /**
     * 提示消息
     */
    protected $message = [
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['book_id', 'catalog_id', 'title'],
        'edit' => ['book_id', 'catalog_id', 'title'],
    ];
    
}
