<?php
namespace app\api\controller;

use app\common\controller\Api;

class Content extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    /**
     * @var \app\admin\model\Content
     */
    protected $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\admin\model\Content;
    }

    public function index()
    {
        $id = $this->request->get('id/d');
        if (empty($id)) {
            $this->error('无效的请求');
        }
        $row = $this->model->get($id);
        if (empty($row)) {
            $this->error('暂无数据');
        }
        if (!$this->hasBook($row['book_id'])) {
            $this->error('未持有此内容');
        }
        $this->success('success', $row);
    }

}
