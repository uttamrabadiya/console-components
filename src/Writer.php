<?php

namespace ConsoleComponents;

use ConsoleComponents\View\Components\Factory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method static void alert(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static mixed ask(string $question, string $default = null, bool $multiline = false, bool $hidden = false)
 * @method static mixed askWithCompletion(string $question, array|callable $choices, string $default = null)
 * @method static void bulletList(array $elements, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static mixed choice(string $question, array $choices, $default = null, int $attempts = null, bool $multiple = false)
 * @method static bool confirm(string $question, bool $default = false)
 * @method static void error(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void info(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void line(string $style, string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void task(string $description, ?callable $task = null, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void twoColumnDetail(string $first, ?string $second = null, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void warn(string $string, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 * @method static void table(array $headers, array $values, int $verbosity = OutputInterface::VERBOSITY_NORMAL)
 */
class Writer
{
    private static ?Factory $factory = null;

    private static OutputInterface $output;

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
            self::$output = new ConsoleOutput();

            $outputStyle = new OutputStyle($input, self::$output);
            self::$factory = new Factory($outputStyle);
        }
        return self::$factory->$method(...$parameters);
    }

    public static function fake(): void
    {
        $input = new ArgvInput();
        self::$output = new BufferedOutput();

        $outputStyle = new OutputStyle($input, self::$output);
        self::$factory = new Factory($outputStyle);
    }

    public static function output(): OutputInterface
    {
        return self::$output;
    }
}