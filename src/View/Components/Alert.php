<?php

namespace ConsoleComponents\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
use ConsoleComponents\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use ConsoleComponents\View\Components\Mutators\EnsurePunctuation;

class Alert extends Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $string
     * @param  int  $verbosity
     * @return void
     */
    public function render($string, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $string = $this->mutate($string, [
            EnsureDynamicContentIsHighlighted::class,
            EnsurePunctuation::class,
        ]);

        $this->renderView('alert', [
            'content' => $string,
        ], $verbosity);
    }
}
