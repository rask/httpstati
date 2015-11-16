<?php

namespace Httpstati\Commands;

use Httpstati\StatusCode;
use Httpstati\StatusCodes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 *
 * Lists all HTTP status codes in a neat table.
 *
 * @package Httpstati\Commands
 */
class CodesCommand extends Command
{
    /**
     * Configure the command.
     *
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this->setName('codes')->setDescription('List all HTTP status codes');

        $this->addArgument('code', InputArgument::OPTIONAL, 'Display information for a certain status code, e.g. 301 or 404, or read about categories using 1, 2, 3, 4 or 5.');
        $this->addOption('category', 'c', InputOption::VALUE_OPTIONAL, 'Table mode: lisplay codes only from a category, e.g. 2 or 3');
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
        $style = new OutputFormatterStyle('red', null, array('bold'));
        $output->getFormatter()->setStyle('attn', $style);

        $singleCode = $input->getArgument('code');

        if (!$singleCode) {
            $this->outputCodesTable($input, $output);
        } else {
            if (strpos($singleCode, 'x') !== false || strlen($singleCode) < 3) {
                $this->outputSingleCategory($singleCode, $input, $output);
            } else {
                $this->outputSingleCode($singleCode, $input, $output);
            }
        }
    }

    /**
     * Output a single status code page.
     *
     * @access protected
     *
     * @param Integer $singleCode
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function outputSingleCode($singleCode, InputInterface $input, OutputInterface $output)
    {
        $code = StatusCodes::getSingleCode($singleCode);

        if (!$code) {
            throw new \Exception('Could not find a status code with that number');
        }

        // Print as page.
        $code->render($output);
    }

    /**
     * Output a single code group page.
     *
     * @access protected
     *
     * @param String|Integer $singleCat
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function outputSingleCategory($singleCat, InputInterface $input, OutputInterface $output)
    {
        $cat = StatusCodes::getSingleCategory($singleCat);

        if (!$cat) {
            throw new \Exception('Could not find a category with that code');
        }

        $cat->render($output);
    }

    /**
     * Render the status codes table. Optionally filter groups.
     *
     * @access protected
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function outputCodesTable(InputInterface $input, OutputInterface $output)
    {
        $codes = StatusCodes::$codes;

        $table = new Table($output);
        //$table->setStyle('borderless');

        $table->setHeaders(['Code', 'Title']);

        $cat = $input->getOption('category');

        foreach ($codes as $sectionHead => $section) {
            if ($cat && strpos($sectionHead, $cat) !== 0) {
                continue;
            }

            $sectionCodes = $section['codes'];

            if (!empty($sectionCodes)) {
                $table->addRow(['<comment>' . $sectionHead . '</comment>']);
                $table->addRow(new TableSeparator());

                foreach ($sectionCodes as $code => $data) {
                    $table->addRow([$code, $data['title']]);
                }

                if (strpos($sectionHead, '5xx') !== 0 && !$cat) {
                    $table->addRow(new TableSeparator());
                }
            }
        }

        $table->render();
    }
}
