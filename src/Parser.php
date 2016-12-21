<?php
namespace Nkey\Caribu\Console;

/**
 * This class is part of Caribu command line interface framework
 *
 * @author Maik Greubel <greubel@nkey.de>
 */
interface Parser
{

    /**
     * Parse the input into command and arguments
     *
     * @param string $input The command string to parse
     * @throws \Nkey\Caribu\Console\ParserException
     * @return ParsedCommand The parsed command
     */
    public function parse(string $input): ParsedCommand;
}
