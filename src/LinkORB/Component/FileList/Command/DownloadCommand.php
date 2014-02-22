<?php

namespace LinkORB\Component\FileList\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LinkORB\Component\FileList\Driver\FileSystemDriver;
use LinkORB\Component\FileList\Utils;

class DownloadCommand extends Command
{

    protected function configure()
    {
        $this->setName('filelist:download')
            ->setDescription(
                'Download files from a filelist to a local file'
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
                'Remote filename to download'
            )
            ->addArgument(
                'outputfilename',
                InputArgument::REQUIRED,
                'Local filename to save to'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $configfilename = $input->getOption('config');
        $config = Utils::loadConfig($configfilename);
        $driver = Utils::getDriverFromConfig($config);

        $key = $input->getArgument('key');
        $filename = $input->getArgument('filename');
        $outputfilename = $input->getArgument('outputfilename');

        $filelist = $driver->getFileListByKey($key);
        $filelist->download($outputfilename, $filename);
        $output->writeln("Download complete");
    }
}
