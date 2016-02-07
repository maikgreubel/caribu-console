<?php
namespace Nkey\Caribu\Console;

/**
 * This class is part of Caribu command line interface framework
 *
 * @author Maik Greubel <greubel@nkey.de>
 */
class DefaultParser implements Parser
{

    /**
     * (non-PHPdoc)
     *
     * @see \Nkey\Caribu\Console\Parser::parse()
     */
    public function parse(string $input): ParsedCommand
    {
        $pattern = '#(?<cmd>^"[^"]*"|\S*) *(?<prm>.*)?#';
        $sentencePattern = '#[^\s"\']+|"([^"]*)"|\'([^\']*)\'#';
        
        $matches = array();
        if (! preg_match($pattern, $input, $matches)) {
            throw new ParserException("Could not parse command");
        }
        $cmd = $matches['cmd'];
        
        $args = array();
        if (! preg_match_all($sentencePattern, $matches['prm'], $args)) {
            $args = $matches['prm'];
        } else {
            $realArgs = array();
            foreach ($args[0] as $arg) {
                $realArgs[] = str_replace(array(
                    '"',
                    "'"
                ), '', $arg);
            }
            $args = $realArgs;
        }
        
        if (is_array($args)) {
            $tmp = array();
            foreach ($args as $arg) {
                if (is_string($arg) && ! empty($arg)) {
                    $tmp[] = $arg;
                }
            }
            $args = $tmp;
        } else 
            if (is_string($args) && ! empty($args)) {
                $args[] = $args;
            } else {
                $args = array();
            }
        
        return new ParsedCommand($cmd, $args);
    }
}
