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
     * @param string $input            
     * @throws \Nkey\Caribu\Console\ParserException
     */
    public function parse($input);
}