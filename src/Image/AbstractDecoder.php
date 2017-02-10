<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:07
 */
namespace Notadd\Foundation\Image;

use Imagick;
use Notadd\Foundation\Image\Exceptions\NotReadableException;

/**
 * Class AbstractDecoder.
 */
abstract class AbstractDecoder
{
    /**
     * @param string $path
     *
     * @return \Notadd\Foundation\Image\Image
     */
    abstract public function initFromPath($path);

    /**
     * @param string $data
     *
     * @return \Notadd\Foundation\Image\Image
     */
    abstract public function initFromBinary($data);

    /**
     * @param resource $resource
     *
     * @return \Notadd\Foundation\Image\Image
     */
    abstract public function initFromGdResource($resource);

    /**
     * @param Imagick $object
     *
     * @return \Notadd\Foundation\Image\Image
     */
    abstract public function initFromImagick(Imagick $object);

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @param string $url
     *
     * @return \Notadd\Foundation\Image\Image
     *
     * @throws \Notadd\Foundation\Image\Exceptions\NotReadableException
     */
    public function initFromUrl($url)
    {
        if ($data = @file_get_contents($url)) {
            return $this->initFromBinary($data);
        }
        throw new NotReadableException('Unable to init from given url (' . $url . ').');
    }

    /**
     * @param $stream
     *
     * @return \Notadd\Foundation\Image\Image
     *
     * @throws \Notadd\Foundation\Image\Exceptions\NotReadableException
     */
    public function initFromStream($stream)
    {
        $offset = ftell($stream);
        rewind($stream);
        $data = @stream_get_contents($stream);
        fseek($stream, $offset);
        if ($data) {
            return $this->initFromBinary($data);
        }
        throw new NotReadableException('Unable to init from given stream');
    }

    /**
     * @return bool
     */
    public function isGdResource()
    {
        if (is_resource($this->data)) {
            return get_resource_type($this->data) == 'gd';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isImagick()
    {
        return is_a($this->data, 'Imagick');
    }

    /**
     * @return bool
     */
    public function isNotaddImage()
    {
        return is_a($this->data, '\Notadd\Foundation\Image\Image');
    }

    /**
     * @return bool
     */
    public function isSplFileInfo()
    {
        return is_a($this->data, 'SplFileInfo');
    }

    /**
     * @return bool
     */
    public function isSymfonyUpload()
    {
        return is_a($this->data, 'Symfony\Component\HttpFoundation\File\UploadedFile');
    }

    /**
     * @return bool
     */
    public function isFilePath()
    {
        if (is_string($this->data)) {
            return is_file($this->data);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isUrl()
    {
        return (bool)filter_var($this->data, FILTER_VALIDATE_URL);
    }

    /**
     * @return bool
     */
    public function isStream()
    {
        if (!is_resource($this->data)) {
            return false;
        }
        if (get_resource_type($this->data) !== 'stream') {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isBinary()
    {
        if (is_string($this->data)) {
            $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $this->data);

            return substr($mime, 0, 4) != 'text' && $mime != 'application/x-empty';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isDataUrl()
    {
        $data = $this->decodeDataUrl($this->data);

        return is_null($data) ? false : true;
    }

    /**
     * @return bool
     */
    public function isBase64()
    {
        if (!is_string($this->data)) {
            return false;
        }

        return base64_encode(base64_decode($this->data)) === $this->data;
    }

    /**
     * @param Image $object
     *
     * @return \Notadd\Foundation\Image\Image
     */
    public function initFromNotaddImage($object)
    {
        return $object;
    }

    /**
     * @param string $data_url
     *
     * @return string
     */
    private function decodeDataUrl($data_url)
    {
        if (!is_string($data_url)) {
            return null;
        }
        $pattern = "/^data:(?:image\/[a-zA-Z\-\.]+)(?:charset=\".+\")?;base64,(?P<data>.+)$/";
        preg_match($pattern, $data_url, $matches);
        if (is_array($matches) && array_key_exists('data', $matches)) {
            return base64_decode($matches['data']);
        }

        return null;
    }

    /**
     * @param mixed $data
     *
     * @return \Notadd\Foundation\Image\Image
     *
     * @throws \Notadd\Foundation\Image\Exceptions\NotReadableException
     */
    public function init($data)
    {
        $this->data = $data;
        switch (true) {
            case $this->isGdResource():
                return $this->initFromGdResource($this->data);
            case $this->isImagick():
                return $this->initFromImagick($this->data);
            case $this->isNotaddImage():
                return $this->initFromNotaddImage($this->data);
            case $this->isSplFileInfo():
                return $this->initFromPath($this->data->getRealPath());
            case $this->isBinary():
                return $this->initFromBinary($this->data);
            case $this->isUrl():
                return $this->initFromUrl($this->data);
            case $this->isStream():
                return $this->initFromStream($this->data);
            case $this->isFilePath():
                return $this->initFromPath($this->data);
            case $this->isDataUrl():
                return $this->initFromBinary($this->decodeDataUrl($this->data));
            case $this->isBase64():
                return $this->initFromBinary(base64_decode($this->data));
            default:
                throw new NotReadableException('Image source not readable');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->data;
    }
}
