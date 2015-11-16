<?php

namespace Httpstati;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PrintsPage
 *
 * @package Httpstati
 */
trait PrintsPage
{
    /**
     * Status code number.
     *
     * @var Integer
     */
    public $number;

    /**
     * Status code title.
     *
     * @var String
     */
    public $title;

    /**
     * Status code short description.
     *
     * @var String
     */
    public $shortDescription;

    /**
     * Status code long description.
     *
     * @var String
     */
    public $description;

    /**
     * Format a piece of text to terminal size.
     *
     * @access protected
     *
     * @param String $paragraph Paragraph to format for console.
     *
     * @return mixed
     */
    protected function formatParagraphs($paragraph)
    {
        if (strlen($paragraph) < 60) {
            return "\t" . $paragraph;
        }

        $lines = [];
        $words = explode(' ', $paragraph);
        $line = "\t";

        for ($i = 0; $i < count($words); $i++) {
            $word = $words[$i];

            if (strlen($line) > 57) {
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
     * Parse description.
     *
     * @param String $desc
     *
     * @return String
     */
    protected function parseDescription($desc)
    {
        $repl = [
            'SHOULD NOT' => '<comment>SHOULD NOT</comment>',
            'SHOULD' => '<comment>SHOULD</comment>',
            'MAY' => '<info>MAY</info>',
            'MUST NOT' => '<attn>MUST NOT</attn>',
            'MUST' => '<attn>MUST</attn>',
            'Note:' => '<comment>Note:</comment>'
        ];

        foreach ($repl as $from => $to) {
            $desc = str_replace($from, $to, $desc);
        }

        return $desc;
    }

    /**
     * Print a page to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function render(OutputInterface $output)
    {
        $title = $this->number . ' ' . $this->title;
        $summary = $this->formatParagraphs($this->shortDescription);

        $descStrings = $this->description;
        $descStrings = array_map([$this, 'formatParagraphs'], $descStrings);
        $description = implode("\n\n", $descStrings);

        $description = $this->parseDescription($description);

        $t = "\t";

        $lines = [
            '',
            sprintf('%s<comment>%s</comment>', $t, $title),
            '',
            sprintf('<info>%s</info>', $summary),
            '',
            $description
        ];

        foreach ($lines as $line) {
            $output->writeln($line);
        }
    }
}
