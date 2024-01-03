<?php
namespace app\api\controller;

use app\common\controller\Api;

class Book extends Api
{
    use \app\api\library\traits\Api;

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    /**
     * @var \app\admin\model\Book
     */
    protected $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\admin\model\Book;
    }

    public function index()
    {
        $flag = $this->request->get('mine');
        $where = [];
        $join = [];
        if (!empty($flag)) {
            $where['user.admin_id'] = $this->auth->id;
            array_push($join, [
                'fa_book_user user', 'user.book_id = book.id', 'left'
            ]);
        }

        $this->initPage();
        $total = $this->model
            ->where($where)
            ->join($join)
            ->count();
        $rows = $this->model
            ->alias('book')
            ->where($where)
            ->join($join)
            ->order('user.created_at desc')
            ->limit($this->trait_limit_start, $this->trait_page_len)
            ->select();
        $this->success('success', [
            'page' => $this->trait_page,
            'page_len' => $this->trait_page_len,
            'total' => $total,
            'rows' => $rows
        ]);
    }
}
