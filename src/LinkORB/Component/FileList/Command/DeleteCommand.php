<?php

namespace LinkORB\Component\FileList\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LinkORB\Component\FileList\Driver\FileSystemDriver;
use LinkORB\Component\FileList\Utils;

class DeleteCommand extends Command
{

    protected function configure()
    {
        $this->setName('filelist:delete')
            ->setDescription(
                'Delete files from a filelist'
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
            )
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Filename to delete'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $configfilename = $input->getOption('config');
        $config = Utils::loadConfig($configfilename);
        $driver = Utils::getDriverFromConfig($config);

        $key = $input->getArgument('key');
        $filename = $input->getArgument('filename');

        $filelist = $driver->getFileListByKey($key);
        $filelist->delete($filename);
        $output->writeln("File deleted");
    }
}
