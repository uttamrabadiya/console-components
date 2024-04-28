<?php

namespace ConsoleComponents\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
use ConsoleComponents\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use ConsoleComponents\View\Components\Mutators\EnsureNoPunctuation;

class TwoColumnDetail extends Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $first
     * @param  string|null  $second
     * @param  int  $verbosity
     * @return void
     */
    public function render($first, $second = null, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $first = $this->mutate($first, [
            EnsureDynamicContentIsHighlighted::class,
            EnsureNoPunctuation::class,
        ]);

        $second = $this->mutate($second, [
            EnsureDynamicContentIsHighlighted::class,
            EnsureNoPunctuation::class,
        ]);

        $this->renderView('two-column-detail', [
            'first' => $first,
            'second' => $second,
        ], $verbosity);
    }
}
