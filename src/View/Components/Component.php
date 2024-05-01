<?php

namespace ConsoleComponents\View\Components;

use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use ConsoleComponents\OutputStyle;
use ConsoleComponents\QuestionHelper;
use function Termwind\render;
use function Termwind\renderUsing;

abstract class Component
{
    /**
     * The output style implementation.
     *
     * @var OutputStyle
     */
    protected $output;

    /**
     * The list of mutators to apply on the view data.
     *
     * @var array<int, callable(string): string>
     */
    protected $mutators;

    /**
     * Creates a new component instance.
     *
     * @param OutputStyle $output
     * @return void
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Renders the given view.
     *
     * @param  string  $view
     * @param  Arrayable|array  $data
     * @param  int  $verbosity
     * @return void
     */
    protected function renderView($view, $data, $verbosity)
    {
        renderUsing($this->output);

        render($this->compile($view, $data), $verbosity);
    }

    /**
     * Compile the given view contents.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    protected function compile($view, $data)
    {
        extract($data);

        ob_start();

        include __DIR__."/../../resources/views/components/$view.php";

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Mutates the given data with the given set of mutators.
     *
     * @param  array<int, string>|string  $data
     * @param  array<int, callable(string): string>  $mutators
     * @return array<int, string>|string
     */
    protected function mutate($data, $mutators)
    {
        foreach ($mutators as $mutator) {
            $mutator = new $mutator;

            if (is_iterable($data)) {
                foreach ($data as $key => $value) {
                    $data[$key] = $mutator($value);
                }
            } else {
                $data = $mutator($data);
            }
        }

        return $data;
    }

    /**
     * Eventually performs a question using the component's question helper.
     *
     * @param  callable  $callable
     * @return mixed
     */
    protected function usingQuestionHelper($callable)
    {
        $property = (new ReflectionClass(OutputStyle::class))
            ->getParentClass()
            ->getProperty('questionHelper');

        $currentHelper = $property->isInitialized($this->output)
            ? $property->getValue($this->output)
            : new SymfonyQuestionHelper();

        $property->setValue($this->output, new QuestionHelper);

        try {
            return $callable();
        } finally {
            $property->setValue($this->output, $currentHelper);
        }
    }

    /**
     * Given a start time, format the total run time for human readability.
     *
     * @param  float  $startTime
     * @param  float  $endTime
     * @return string
     */
    protected function runTimeForHumans($startTime, $endTime = null)
    {
        $endTime ??= microtime(true);

        $runTime = ($endTime - $startTime) * 1000;

        return $runTime > 1000
            ? $this->formatRuntime($runTime)
            : number_format($runTime, 2).'ms';
    }

    function formatRuntime($runTime): string
    {
        $seconds = floor($runTime / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);

        $formattedTime = '';

        if ($hours > 0) {
            $formattedTime .= $hours . 'h ';
        }

        if ($minutes > 0) {
            $formattedTime .= ($minutes % 60) . 'm ';
        }

        if ($seconds > 0 && $hours == 0) {
            $formattedTime .= ($seconds % 60) . 's';
        }

        return trim($formattedTime);
    }

}
