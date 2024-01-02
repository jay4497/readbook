<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 音频
 *
 * @icon fa fa-circle-o
 */
class Record extends Backend
{

    /**
     * Record模型对象
     * @var \app\admin\model\Record
     */
    protected $model = null;

    protected $modelValidate = true;
    protected $modelSceneValidate = true;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Record;

    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function add_multi()
    {
        if (false === $this->request->isPost()) {
            return $this->view->fetch();
        }
        $params = $this->request->post('row/a');
        if (empty($params)) {
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $params = $this->preExcludeFields($params);

        $text_data = $params['text'];
        $text_data_array = array_filter(explode('\\r\\n', $text_data));
        $audio_data = $params['audio'];
        $audio_data_array = array_filter(explode(',', $audio_data));
        $text_data_array_len = count($text_data_array);
        $audio_data_array_len = count($audio_data_array);
        if ($text_data_array_len !== $audio_data_array_len) {
            $this->error(__('Text pieces are not equal to audio\'s'));
        }
        $save_data = [];
        foreach ($text_data_array as $k => $val) {
            array_push($save_data, [
                'content_id' => $params['content_id'],
                'text' => $val,
                'audio' => $audio_data_array[$k],
                'flag' => $params['flag']
            ]);
        }

        if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
            $params[$this->dataLimitField] = $this->auth->id;
        }
        $result = false;
        Db::startTrans();
        try {
            //是否采用模型验证
            if ($this->modelValidate) {
                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                $this->model->validateFailException()->validate($validate);
            }
            $result = $this->model->allowField(true)->saveAll($save_data);
            Db::commit();
        } catch (ValidateException|PDOException|\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($result === false) {
            $this->error(__('No rows were inserted'));
        }
        $this->success();
    }

}
