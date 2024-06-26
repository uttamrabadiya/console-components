<?php

namespace ConsoleComponents\View\Components;

use InvalidArgumentException;
use Symfony\Component\Console\Output\OutputInterface;
use ConsoleComponents\OutputStyle;

/**
 * @method void alert(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method mixed ask(string $question, string $default = null)
 * @method mixed askWithCompletion(string $question, array|callable $choices, string $default = null)
 * @method void bulletList(array $elements, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method mixed choice(string $question, array $choices, $default = null, int $attempts = null, bool $multiple = false)
 * @method bool confirm(string $question, bool $default = false)
 * @method void error(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void info(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void line(string $style, string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void task(string $description, ?callable $task = null, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void twoColumnDetail(string $first, ?string $second = null, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void warn(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method void table(array $headers, array $values, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 */
class Factory
{
    /**
     * The output interface implementation.
     *
     * @var OutputStyle
     */
    protected $output;

    /**
     * Creates a new factory instance.
     *
     * @param  OutputStyle  $output
     * @return void
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Dynamically handle calls into the component instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __call($method, $parameters)
    {
        $component = '\ConsoleComponents\View\Components\\'.ucfirst($method);

        if (!class_exists($component)) {
            throw new InvalidArgumentException(sprintf(
                'Console component [%s] not found.', $method
            ));
        }

        return (new $component($this->output))->render(...$parameters);
    }
}
