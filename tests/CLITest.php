<?php
namespace Nkey\Caribu\Console\Test;

use Nkey\Caribu\Console\CLI;

class CLITest extends \PHPUnit\Framework\TestCase
{

    private $stdin;

    private $stdout;

    private $stderr;

    private $cli;

    protected function setUp()
    {
        // Use temporary stream to simulate stdin input
        $this->stdin = fopen("php://memory", "r+");
        $this->stdout = fopen("php://memory", "r+");
        $this->stderr = fopen("php://memory", "r+");
        
        $this->cli = new CLI();
        $this->cli->setStdIn($this->stdin);
        $this->cli->setStdOut($this->stdout);
        $this->cli->setStdErr($this->stderr);
    }

    protected function tearDown()
    {
        fclose($this->stdin);
        fclose($this->stdout);
        fclose($this->stderr);
    }

    public function testCli()
    {
        // Test stdin
        fprintf($this->stdin, "exit" . PHP_EOL);
        rewind($this->stdin);
        $parsed = $this->cli->readLine();
        $this->assertEquals("exit", $parsed->getCommand());
        
        // Test stdout
        $this->cli->writeStdoutLine($parsed->getCommand());
        rewind($this->stdout);
        $readen = stream_get_line($this->stdout, 1024, PHP_EOL);
        $this->assertEquals("cli > exit", $readen);
        
        // Test stderr
        $this->cli->writeStderrLine("Error while processing command");
        rewind($this->stderr);
        $readen = stream_get_line($this->stderr, 1024, PHP_EOL);
        $this->assertEquals("Error while processing command", $readen);
    }

    public function testCliParsing()
    {
        fprintf($this->stdin, "printf 'Hello World'" . PHP_EOL);
        rewind($this->stdin);
        $parsed = $this->cli->readLine();
        $this->assertEquals("printf", $parsed->getCommand());
        $this->assertEquals(1, count($parsed->getArguments()));
        $this->assertEquals("Hello World", $parsed->getArguments()[0]);
    }
}
