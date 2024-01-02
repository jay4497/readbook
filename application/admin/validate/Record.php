<?php

namespace app\admin\validate;

use think\Validate;

class Record extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'content_id' => 'require',
        'text' => 'require',
        'audio' => 'require'
    ];

    protected $field = [
        'content_id' => '内容',
        'text' => '文本',
        'audio' => '音频'
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
        'add'  => ['content_id', 'text', 'audio'],
        'edit' => ['content_id', 'text', 'audio'],
    ];
    
}
