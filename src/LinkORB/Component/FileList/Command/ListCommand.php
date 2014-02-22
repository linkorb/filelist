<?php

namespace LinkORB\Component\FileList\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LinkORB\Component\FileList\Driver\FileSystemDriver;
use LinkORB\Component\FileList\Utils;

class ListCommand extends Command
{

    protected function configure()
    {
        $this->setName('filelist:list')
            ->setDescription(
                'List files in a list'
            )
            ->addOption(
                'config',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Config filename'
            )
            ->addArgument(
                'key',
                InputArgument::REQUIRED,
                'The key to store the uploaded file under'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $configfilename = $input->getOption('config');
        $config = Utils::loadConfig($configfilename);
        $driver = Utils::getDriverFromConfig($config);

        $key = $input->getArgument('key');

        $filelist = $driver->getFileListByKey($key);

        foreach ($filelist->getFiles() as $file) {
            $output->writeln(" * [" . $file->getFilename() . "]");
        }
    }
}
