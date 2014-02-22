<?php

namespace LinkORB\Component\FileList\Driver;

use LinkORB\Component\FileList\File;
use LinkORB\Component\FileList\FileList;

class FileSystemDriver implements DriverInterface
{
    protected $path;

    public function __construct($path)
    {

        $path =rtrim($path, '/');
        $this->path = $path;
    }

    protected function getFullPath($key)
    {
        $fullpath = $this->path . '/' . str_replace('.', '/', $key);
        //exit("key:$key so fullpath=[$fullpath]");
        return $fullpath;
    }

    private function ensurePath($path)
    {
        if (file_exists($path)) {
            return true;
        }
        mkdir($path, 0777, true);
    }

    public function getFilesInList($filelist)
    {
        $fullpath = $this->getFullPath($filelist->getKey());
        $dirfiles = glob($fullpath . '/*');

        if (!file_exists($fullpath)) {
            return array();
        }

        foreach ($dirfiles as $filename) {
            $file = new File($filelist, basename($filename));
            $files[] = $file;
        }
        return $files;
    }

    public function set($filelist, $filename, $data)
    {
        $fullpath = $this->getFullPath($filelist->getKey());
        $this->ensurePath($fullpath);
        file_put_contents($fullpath . '/' . $filename, $data);
    }

    public function get($filelist, $filename)
    {
        $fullpath = $this->getFullPath($filelist->getKey());
        $data = file_get_contents($fullpath . '/' . $filename);
        return $data;
    }

    public function delete($filelist, $filename)
    {
        $fullpath = $this->getFullPath($filelist->getKey());
        unlink($fullpath . '/' . $filename);
    }

    public function getFileListByKey($key)
    {
        return new FileList($key, $this);
    }

}