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



    /**
    * Filter filename.
    * @param string $name The original filename.
    * @return string The filtered file name.
    */
    public static function filterFilename($name)
    {
        $name = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $name);
        $name = preg_replace('/_+/', '_', $name);
        $name = str_replace('..', '.', $name);
        return $name;
    }


    public function get($filename)
    {
        $filename = $this->filterFilename($filename);
        $data = $this->driver->get($this, $filename);
        return $data;
    }

    public function set($filename, $data)
    {
        $filename = $this->filterFilename($filename);        
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
