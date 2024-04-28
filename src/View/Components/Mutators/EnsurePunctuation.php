<?php

namespace ConsoleComponents\View\Components\Mutators;

class EnsurePunctuation
{
    /**
     * Ensures the given string ends with punctuation.
     *
     * @param  string  $string
     * @return string
     */
    public function __invoke($string)
    {
        $endsWith = false;
        foreach (['.', '?', '!', ':'] as $punctuation) {
            if (str_ends_with($string, $punctuation)) {
                $endsWith = true;
                break;
            }
        }
        if (!$endsWith) {
            return "$string.";
        }

        return $string;
    }
}
