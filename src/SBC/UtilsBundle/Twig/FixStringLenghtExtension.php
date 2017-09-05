<?php

namespace SBC\UtilsBundle\Twig;


class FixStringLenghtExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('fix_string_length',array($this, 'fixStringLength')),
        );
    }

    public function fixStringLength($string, $minLength, $maxLength)
    {

        if (strlen($string) > $maxLength) {
            $string = substr($string, 0, $maxLength ) . ' ...';
        }

        if (strlen($string) < $minLength) {

            for ($i = 0; $i <= $maxLength - 3; $i++) {
                $string = html_entity_decode($string . '&nbsp;');
            }

        }

        return $string;
    }

    public function getName()
    {
        return 'fix_string_length';
    }

}