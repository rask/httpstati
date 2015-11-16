<?php

namespace Httpstati\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AboutCommand
 *
 * @package Httpstati\Commands
 */
class AboutCommand extends Command
{
    /**
     * Configure the command.
     *
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this->setName('about')->setDescription('About this application');
    }

    /**
     * Output the command.
     *
     * @access protected
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln("\t" . '<comment>httpstati</comment>');
        $output->writeln('');
        $output->writeln("\t" . 'This commandline application can be used to read about the' . "\n\t" . 'common HTTP status codes.');
        $output->writeln('');
        $output->writeln("\t" . 'All the information available with this application has been' . "\n\t" . 'gathered from');
        $output->writeln('');
        $output->writeln("\t" . '-   HTTP Protocol RFC 2616, section 10');
        $output->writeln('');
        $output->writeln("\t" . 'This application has been written by' . "\n\t" . 'Otto Rask (github.com/rask).');
    }
}
