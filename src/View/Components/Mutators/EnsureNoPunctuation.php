<?php

namespace ConsoleComponents\View\Components\Mutators;

class EnsureNoPunctuation
{
    /**
     * Ensures the given string does not end with punctuation.
     *
     * @param  string  $string
     * @return string
     */
    public function __invoke($string)
    {
        foreach (['.', '?', '!', ':'] as $punctuation) {
            if (str_ends_with($string, $punctuation)) {
                return substr_replace($string, '', -1);
            }
        }

        return $string;
    }
}
