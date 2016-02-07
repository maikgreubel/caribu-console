<?php
namespace Nkey\Caribu\Console;

/**
 * This class is part of Caribu command line interface framework
 *
 * @author Maik Greubel <greubel@nkey.de>
 */
class ParsedCommand
{

    /**
     * The command
     *
     * @var string
     */
    private $command;

    /**
     * List of arguments
     *
     * @var string[]
     */
    private $args;

    /**
     * Create a new parsed command instance
     *
     * @param string $command
     *            The command
     * @param array $args
     *            Optional arguments
     */
    public function __construct(string $command, array $args = array())
    {
        $this->command = $command;
        $this->args = $args;
    }

    /**
     * Retrieve the parsed command
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Retrieve list of arguments
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->args;
    }
}
