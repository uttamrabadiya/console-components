<?php

namespace ConsoleComponents\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
use ConsoleComponents\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use ConsoleComponents\View\Components\Mutators\EnsureNoPunctuation;

class BulletList extends Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  array<int, string>  $elements
     * @param  int  $verbosity
     * @return void
     */
    public function render($elements, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $elements = $this->mutate($elements, [
            EnsureDynamicContentIsHighlighted::class,
            EnsureNoPunctuation::class,
        ]);

        $this->renderView('bullet-list', [
            'elements' => $elements,
        ], $verbosity);
    }
}
