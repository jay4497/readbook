<?php
namespace app\common\library;

class Audio
{
    /**
     * 格式化音频的上传路径
     *
     * @param string $path
     * @param string|null $playurl
     * @return string
     */
    public function uploadPath($path, $playurl = null)
    {
        $path = str_replace('/../resources', '', $path);
        if (!empty($playurl)) {
            return $playurl . '?audio=' . $path;
        }
        return $path;
    }

    /**
     * 发送音频文件流
     * 该功能依赖 NGINX 的 X-Accel 模块，需配置如下
     * location /audio {
     *     internal;
     *     alias /path/to/resources/audio;
     * }
     *
     * @param string $path
     * @param string|null $mime
     */
    public function sendAudio($path, $mime = null)
    {
        if (empty($mime)) {
            $segments = explode('.', $path);
            $ext = array_pop($segments);
            $mime = $this->getMime($ext);
        }

        ob_clean();
        header('Content-type: '. $mime);
        // header('Content-Disposition: attachment; filename="filename.zip"');
        header('X-Accel-Buffering: no');
        header('X-Accel-Limit-Rate: 500000');
        header('X-Accel-Redirect: '. $path);
        exit;
    }

    private function getMime($ext)
    {
        $map = [
            'mp3' => 'audio/mpeg',
            'm4a' => 'audio/mp4',
            'wav' => 'audio/wav',
            'ogg' => 'audio/ogg',
            'opus' => 'audio/opus'
        ];
        if (isset($map[$ext])) {
            return $map[$ext];
        }
        return '';
    }
}
