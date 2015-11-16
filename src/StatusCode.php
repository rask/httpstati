<?php

namespace Httpstati;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StatusCode
 *
 * @package Httpstati
 */
class StatusCode implements PagePrintable
{
    use PrintsPage;

    /**
     * StatusCode constructor.
     *
     * @param Integer $number 100-500 status code number.
     * @param String $title E.g. "Not Found"
     * @param String $shortDescription A short paragraph description
     * @param String $description Long multi paragraph description.
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
}
