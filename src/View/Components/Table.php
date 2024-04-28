<?php

namespace ConsoleComponents\View\Components;

use ConsoleComponents\Contracts\NewLineAware;
use Symfony\Component\Console\Output\OutputInterface;

class Table extends Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  array  $headers
     * @param  array  $values
     * @param  int  $verbosity
     * @return void
     */
    public function render($headers, $values, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $this->renderView('table', [
            'marginTop' => $this->output instanceof NewLineAware ? max(0, 2 - $this->output->newLinesWritten()) : 1,
            'headers' => $headers,
            'rows' => $values,
        ], $verbosity);
    }
}