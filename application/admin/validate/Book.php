<?php

namespace app\admin\validate;

use think\Validate;

class Book extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'title' => 'require'
    ];

    protected $field = [
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
        'add'  => ['title'],
        'edit' => ['title'],
    ];
    
}
