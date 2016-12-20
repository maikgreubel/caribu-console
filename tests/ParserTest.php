<?php
namespace Nkey\Caribu\Console\Test;

use Nkey\Caribu\Console\DefaultParser;

class ParserTest extends \PHPUnit_Framework_TestCase
{

    public function testSimple()
    {
        $command = "printf";
        
        $parser = new DefaultParser();
        
        $parsedCommand = $parser->parse($command);
        
        $this->assertEquals('printf', $parsedCommand->getCommand());
        $this->assertEquals(0, count($parsedCommand->getArguments()));
    }

    public function testParser()
    {
        $command = 'printf "Hello World" "Master Windoo" fump';
        $parser = new DefaultParser();
        
        $parsedCommand = $parser->parse($command);
        
        $this->assertEquals('printf', $parsedCommand->getCommand());
        $this->assertEquals(3, count($parsedCommand->getArguments()));
        $this->assertEquals('Hello World', $parsedCommand->getArguments()[0]);
    }
    
    /**
     * @expectedException \Nkey\Caribu\Console\ParserException
     */
    public function testParserException()
    {
    	$parser = new DefaultParser();
    	$parsedCommand = $parser->parse('"printf "Hello World');
    }
}
