<?php
namespace app\api\library\traits;

trait Api
{
    public $trait_page;
    public $trait_page_len;
    public $trait_limit_start = 0;

    public function initPage()
    {
        $page = $this->request->get('p/d', 1);
        $page_len = $this->request->get('len/d', 20);

        $page = $page < 1? 1: $page;
        $page_len = $page_len < 1? 1: $page_len;
        $page_len = $page_len > 1000? 1000: $page_len;
        $limit_start = ($page - 1) * $page_len;
        $this->trait_page = $page;
        $this->trait_page_len = $page_len;
        $this->trait_limit_start = $limit_start;
    }
}
