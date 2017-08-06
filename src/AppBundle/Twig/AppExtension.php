<?php

namespace AppBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('prettyDuration', array($this, 'prettyDuration')),
        );
    }

    public function prettyDuration($seconds)
    {
        $hours = sprintf("%02d", floor($seconds / 3600));
        $minutes = sprintf("%02d", floor(($seconds / 60) % 60));
        $seconds = sprintf("%02d", $seconds % 60);

        return "$hours:$minutes:$seconds";
    }

}
