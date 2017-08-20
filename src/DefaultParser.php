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
        list ($cmd, $params) = $this->parseImpl($input);
        $args = $this->parseSentence($params);
        
        $tmp = array();
        foreach ($args as $arg) {
            if (is_string($arg) && ! empty($arg)) {
                $tmp[] = $arg;
            }
        }
        $args = $tmp;
        
        return new ParsedCommand($cmd, $args);
    }

    /**
     * Internal parsing of input
     *
     * @param string $input
     * @throws ParserException
     * @return array
     */
    private function parseImpl(string $input): array
    {
        $pattern = '#(?<cmd>^"[^"]*"|\S*) *(?<prm>.*)?#';
        
        $matches = array();
        if (! preg_match($pattern, $input, $matches)) {
            throw new ParserException("Could not parse command");
        }
        $cmd = $matches['cmd'];
        if (empty($cmd) || strchr($cmd, '"') || strchr($cmd, "'")) {
            throw new ParserException("Could not parse command");
        }
        
        return array(
            $cmd,
            $matches['prm']
        );
    }

    private function parseSentence(string $param): array
    {
        $sentencePattern = '#[^\s"\']+|"([^"]*)"|\'([^\']*)\'#';
        
        $args = array();
        
        if (! preg_match_all($sentencePattern, $param, $args)) {
            $args[] = $param;
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
        
        return $args;
    }
}
