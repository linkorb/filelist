<?php

namespace LinkORB\Component\FileList;

class FileList
{
    private $driver;
    private $key;

    public function __construct($key, $driver)
    {
        $this->driver = $driver;
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getFiles()
    {
        return $this->driver->getFilesInList($this);
    }


    public function get($filename)
    {
        $data = $this->driver->get($this, $filename);
        return $data;
    }

    public function set($filename, $data)
    {
        $this->driver->set($this, $filename, $data);
    }

    public function delete($filename)
    {
        $this->driver->delete($this, $filename);
    }

    public function upload($localfilename, $filename = '')
    {
        $data = file_get_contents($localfilename);
        if ($filename=='') {
            $filename = basename($localfilename);
        }
        $this->driver->set($this, $filename, $data);
    }

    public function download($localfilename, $filename = '')
    {
        if ($filename=='') {
            $filename = basename($localfilename);
        }
        $data = $this->driver->get($this, $filename);
        file_put_contents($localfilename, $data);
    }

    public function getFileCount()
    {
        return count($this->getFiles());
    }
}