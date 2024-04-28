<?php

namespace ConsoleComponents;

use ConsoleComponents\View\Components\Factory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

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
class Writer
{
    private static ?Factory $factory = null;

    /**
     * Dynamically handle calls into the component instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function __callStatic($method, $parameters)
    {
        if (!self::$factory) {
            $input = new ArgvInput();
            $output = new ConsoleOutput();

            $outputStyle = new OutputStyle($input, $output);
            self::$factory = new Factory($outputStyle);
        }
        return self::$factory->$method(...$parameters);
    }
}