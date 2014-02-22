<?php

namespace LinkORB\Component\FileList;

class File
{
    private $filelist;
    private $filename;

    public function __construct($filelist, $filename)
    {
        $this->filelist = $filelist;
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFileList()
    {
        return $this->filelist;
    }
}