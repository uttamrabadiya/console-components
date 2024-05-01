<?php

namespace ConsoleComponents\View\Components;

use Symfony\Component\Console\Question\Question;

class Ask extends Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $question
     * @param  string  $default
     * @param  bool    $multiline
     * @param  bool    $hidden
     * @return mixed
     */
    public function render($question, $default = null, $multiline = false, $hidden = false)
    {
        return $this->usingQuestionHelper(
            fn () => $this->output->askQuestion(
                (new Question($question, $default))
                    ->setHidden($hidden)
                    ->setMultiline($multiline)
            )
        );
    }
}
