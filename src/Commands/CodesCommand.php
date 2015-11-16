<?php

namespace Httpstati\Commands;

use Httpstati\StatusCodes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
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
        $singleCode = $input->getArgument('code');

        if (!$singleCode) {
            $this->outputCodesTable($input, $output);
        } else {
            $this->outputSingleCode($singleCode, $input, $output);
        }
    }

    /**
     * @param $paragraph
     *
     * @return mixed
     */
    protected function formatParagraphs($paragraph)
    {
        if (strlen($paragraph) < 65) {
            return "\t" . $paragraph;
        }

        $lines = [];
        $words = explode(' ', $paragraph);
        $line = "\t";

        foreach ($words as $word) {
            if (strlen($line) > 60) {
                $lines[] = $line;
                $line = "\t";
            }

            $line .= $word . ' ';
        }

        if (!empty($line)) {
            $lines[] = $line;
        }

        $paragraph = implode("\n", $lines);

        return $paragraph;
    }

    /**
     * @param $singleCode
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function outputSingleCode($singleCode, InputInterface $input, OutputInterface $output)
    {
        try {
            $code = StatusCodes::getSingleCode($singleCode);
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return;
        }

        $title = $code['code'] . ' ' . $code['data']['title'];
        $summary = $this->formatParagraphs($code['data']['short_description']);

        $descStrings = $code['data']['description'];

        $descStrings = array_map([$this, 'formatParagraphs'], $descStrings);

        $description = implode("\n\n", $descStrings);

        $t = "\t";

        $output->writeln('');
        $output->writeln($t . '<comment>' . $title . '</comment>');
        $output->writeln('');
        $output->writeln('<info>' . $summary . '</info>');
        $output->writeln('');
        $output->writeln($description);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function outputCodesTable(InputInterface $input, OutputInterface $output)
    {
        $codes = StatusCodes::$codes;

        $table = new Table($output);
        $table->setStyle('borderless');

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
