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
     * @return mixed
     */
    public function render($question, $default = null, $multiline = false)
    {
        return $this->usingQuestionHelper(
            fn () => $this->output->askQuestion(
                (new Question($question, $default))
                    ->setMultiline($multiline)
            )
        );
    }
}
