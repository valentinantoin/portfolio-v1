<?php

namespace App\TwigExtend;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Madlines\Common\AutoLink\AutoLink;

class AutoLinkExtension extends AbstractExtension
{
    const NAME = 'auto_link_extension';

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('autoLink', [$this, 'autoLink']),
        ];
    }

    /**
     * @param string $text
     * @return string
     */
    public function autoLink($text)
    {
        return AutoLink::parse($text);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
