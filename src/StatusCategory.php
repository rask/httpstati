<?php

namespace Httpstati;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StatusCategory
 *
 * @package Httpstati
 */
class StatusCategory implements PagePrintable
{
    use PrintsPage {
        render as pageRender;
    }

    /**
     * StatusCategory constructor.
     *
     * @param Integer|String $number Category numbering.
     * @param String $title Category title.
     * @param String $shortDescription Short descriptive paragraph.
     * @param String $description Long description, multiple paragraphs, etc.
     *
     * @return void
     */
    public function __construct($number, $title, $shortDescription, $description)
    {
        $this->number = $number;
        $this->title = $title;
        $this->shortDescription = $shortDescription;
        $this->description = $description;
    }

    /**
     * Get status codes that belong to this category.
     *
     * @return \Httpstati\StatusCode[]
     */
    protected function getStatusCodes()
    {
        $codes = StatusCodes::$codes;

        $catCodes = [];

        foreach ($codes as $sectionHead => $section) {
            if (strpos($sectionHead, $this->number) === false) {
                continue;
            }

            foreach ($section['codes'] as $codenum => $codedata) {
                $catCodes[] = new StatusCode(
                    $codenum,
                    $codedata['title'],
                    $codedata['short_description'],
                    $codedata['description']
                );
            }
        }

        return $catCodes;
    }

    /**
     * Render the page.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function render(OutputInterface $output)
    {
        $this->pageRender($output);

        $codelist = '';

        foreach ($this->getStatusCodes() as $code) {
            $codelist .= sprintf('%s-   %s %s%s', "\t", $code->number, $code->title, "\n");
        }

        $codelist = rtrim($codelist, "\n");

        $output->writeln('');
        $output->writeln("\t" . '<info>Available status codes in this group:</info>');
        $output->writeln('');
        $output->writeln($codelist);
    }
}
