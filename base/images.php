<?php
class images {

    protected $source;
    protected $content_type;
    protected $width;
    protected $height;
    protected $config;

    public function __construct() {
        $this->_load_config();
        $this->config = config_images::get_directory();
    }

    public function open($source = '') {
        $imagetype = @exif_imagetype($source);

        if(FALSE === $imagetype)
            return FALSE;

        $type = array(
            '',
            'gif',
            'jpeg',
            'png',
            'swf',
            'psd',
            'bmp',
            'tiff_ii',
            'tiff_mm',
            'jpc',
            'jp2',
            'jpx',
            'jb2',
            'swc',
            'iff',
            'wbmp',
            'xbm'
        );

        $this->content_type = $type[$imagetype];

        $accept = array('gif', 'jpeg', 'png');

        if(FALSE === in_array($this->content_type, $accept))
            return FALSE;

        header("Content-type:image/{$this->content_type}");

        if('gif' === $this->content_type)
            $this->source = imagecreatefromgif($source);
        elseif('jpeg' === $this->content_type)
            $this->source = imagecreatefromjpeg($source);
        elseif('png' === $this->content_type)
            $this->source = imagecreatefrompng($source);

        $this->width = imagesX($this->source);
        $this->height = imagesY($this->source);
    }

    public function close() {
        imageDestroy($this->source);
    }

    public function slice($quality = 100) {

        $quality = (int) $quality;

        if(0 === $quality)
            return FALSE;

        $adapter = '';
        if('gif' === $this->content_type)
            $adapter = @imagegif;
        elseif('jpeg' === $this->content_type)
            $adapter = @imagejpeg;
        elseif('png' === $this->content_type)
            $adapter = @imagepng;

        $extension = $this->content_type;
        if('jpeg' === $extension)
            $extension = 'jpg';

        $filename = md5(microtime() . 'slice');
        $filename = "{$filename}.{$extension}";

        foreach($this->config['slice'] as $size => $path) {
            list($width, $height) = explode('-', $size);
            $proportion = $this->height / $this->width;
            $x = $this->width / 2 - $width / 2;
            $y = ($this->height / 2 - $height / 2);
            $height = $height * $proportion;
            if($width > $this->width || 0 > $x) {
                $width = $this->width;
                $x = 0;
            }
            if($height > $this->height || 0 > $y) {
                $height = $this->height;
                $y = 0;
            }
            $target = imagecreatetruecolor($width, $height);
            imagecopy(
               $target,
               $this->source,
               0,
               0,
               $x,
               $y,
               $width,
               $height
            );
            $adapter($target, "{$path}/{$filename}", $quality);
        }

        imageDestroy($target);
        return $filename;
    }

    public function resize($quality = 100) {

        $quality = (int) $quality;

        if(0 === $quality)
            return FALSE;

        $adapter = '';
        if('gif' === $this->content_type)
            $adapter = @imagegif;
        elseif('jpeg' === $this->content_type)
            $adapter = @imagejpeg;
        elseif('png' === $this->content_type)
            $adapter = @imagepng;

        $extension = $this->content_type;
        if('jpeg' === $extension)
            $extension = 'jpg';

        $filename = md5(microtime() . 'resize');
        $filename = "{$filename}.{$extension}";

        foreach($this->config['resize'] as $size => $path) {
            list($width, $height) = explode('-', $size);
            $proportion = $this->height / $this->width;
            $height = $height * $proportion;
            if($width > $this->width)
                $width = $this->width;
            if($height > $this->height)
                $height = $this->height;
            $target = imagecreatetruecolor($width, $height);
            imagecopyresampled(
               $target,
               $this->source,
               0,
               0,
               0,
               0,
               $width,
               $height,
               $this->width,
               $this->height
            );
            $adapter($target, "{$path}/{$filename}", $quality);
        }

        imageDestroy($target);
        return $filename;
    }

    private function _load_config() {
        if(TRUE === empty(config_setting::get_config())) {
            $path = dirname(dirname(dirname(__FILE__)));
            include_once("{$path}/config/config_setting.php");
        }
        $config_path = config_setting::get_config();
        $config_path = $config_path['config_path'];
        include_once("{$config_path}/config_images.php");
    }
}
