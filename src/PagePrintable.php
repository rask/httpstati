<?php

namespace Httpstati;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface PagePrintable
 *
 * @package Httpstati
 */
interface PagePrintable
{
    /**
     * Render a page-like object to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return mixed
     */
    public function render(OutputInterface $output);
}
