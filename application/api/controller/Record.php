<?php
namespace app\api\controller;

use app\common\controller\Api;

class Record extends Api
{
    protected $noNeedRight = '*';
    protected $noNeedLogin = [];

    /**
     * @var \app\admin\model\Record
     */
    protected $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\admin\model\Record;
    }

    public function index()
    {
        $content_id = $this->request->get('cid');
        if (empty($content_id)) {
            $this->error('无效的请求');
        }
        $rows = $this->model
            ->field('id, text, audio, code')
            ->where('content_id', $content_id)
            ->order('weigh desc, id asc')
            ->select();
        $rows = collection($rows)->toArray();
        foreach ($rows as &$item) {
            $item['audio'] = $this->transPath($item['code']);
            unset($item['code']);
        }
        unset($item);
        $this->success('success', $rows);
    }

    public function play($i)
    {
        if (empty($i)) {
            $this->error('无效的请求');
        }
        $record = $this->model
            ->where('code', $i)
            ->find();
        if (empty($record)) {
            $this->error('数据获取出错');
        }
        $content = \think\Db::name('content')
            ->where('id', $record['content_id'])
            ->find();
        if (empty($content)) {
            $this->error('数据获取出错');
        }
        if (!$this->hasBook($content['book_id'])) {
            $this->error('未持有内容');
        }

        header('Content-type: '. $record['mime']);
        // header('Content-Disposition: attachment; filename="filename.zip"');
        header('X-Accel-Buffering: no');
        // header('X-Accel-Limit-Rate: 50000');
        header('X-Accel-Redirect: '. $record['audio']);
        exit;
    }

    private function transPath($code)
    {
        if (empty($code)) {
            return '';
        }
        return url('record/play', ['i' => $code]);
    }
}
