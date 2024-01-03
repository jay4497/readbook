<?php
namespace app\api\controller;

use app\admin\model\Content;
use app\common\controller\Api;
use fast\Tree;

class Catalog extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    /**
     * @var \app\admin\model\Catalog
     */
    protected $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\admin\model\Catalog;
    }

    public function index()
    {
        $book_id = $this->request->get('bid/d');
        if (empty($book_id)) {
            $this->error('无效的请求');
        }
        $rows = $this->model
            ->where('book_id', $book_id)
            ->order('weigh desc, id asc')
            ->select();
        $tree = Tree::instance();
        $tree->init(collection($rows)->toArray(), 'parent_id');
        $data = $tree->getTreeList($tree->getTreeArray(0), 'title');
        $this->success('success', $data);
    }

    public function contents()
    {
        $catalog_id = $this->request->get('cid/d');
        if (empty($catalog_id)) {
            $this->error('无效的请求');
        }
        $model = new Content;
        $rows = $model
            ->field('id, title, cover, book_id, catalog_id')
            ->where('catalog_id', $catalog_id)
            ->order('weigh desc, id asc')
            ->select();
        $this->success('success', $rows);
    }
}
