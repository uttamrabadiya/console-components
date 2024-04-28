<?php

namespace ConsoleComponents\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
use ConsoleComponents\Contracts\NewLineAware;
use ConsoleComponents\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use ConsoleComponents\View\Components\Mutators\EnsurePunctuation;

class Line extends Component
{
    /**
     * The possible line styles.
     *
     * @var array<string, array<string, string>>
     */
    protected static $styles = [
        'info' => [
            'bgColor' => 'blue',
            'fgColor' => 'white',
            'title' => 'info',
        ],
        'warn' => [
            'bgColor' => 'yellow',
            'fgColor' => 'black',
            'title' => 'warn',
        ],
        'error' => [
            'bgColor' => 'red',
            'fgColor' => 'white',
            'title' => 'error',
        ],
    ];

    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $style
     * @param  string  $string
     * @param  int  $verbosity
     * @return void
     */
    public function render($style, $string, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $string = $this->mutate($string, [
            EnsureDynamicContentIsHighlighted::class,
            EnsurePunctuation::class,
        ]);

        $this->renderView('line', array_merge(static::$styles[$style], [
            'marginTop' => $this->output instanceof NewLineAware ? max(0, 2 - $this->output->newLinesWritten()) : 1,
            'content' => $string,
        ]), $verbosity);
    }
}
