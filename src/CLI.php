<?php
namespace Nkey\Caribu\Console;

/**
 * This class is part of Caribu command line interface framework
 *
 * @author Maik Greubel <greubel@nkey.de>
 */
class CLI
{

    /**
     * The command line prompt
     *
     * @var string
     */
    private $prompt;

    /**
     * Handle for stdin channel
     *
     * @var resource
     */
    private $stdin;

    /**
     * Handle for stdout channel
     *
     * @var resource
     */
    private $stdout;

    /**
     * Handle for stderr channel
     *
     * @var resource
     */
    private $stderr;

    /**
     * Command line parser
     *
     * @var Parser
     */
    private $parser;

    /**
     * Create a new CLI instance
     *
     * @param string $prompt
     *            Optional command line prompt (default 'cli')
     * @param \Nkey\Caribu\Console\Parser $parser
     *            Optional command line parser (default instance of \Nkey\Caribu\Console\DefaultParser)
     */
    public function __construct(string $prompt = "cli", Parser $parser = null)
    {
        $this->setPrompt($prompt);
        
        $this->parser = $parser;
        if (null === $this->parser) {
            $this->parser = new DefaultParser();
        }
        
        $this->stdin = fopen("php://stdin", "r");
        $this->stdout = fopen("php://stdout", "w");
        $this->stderr = fopen("php://stderr", "w");
    }

    /**
     * Set a custom stdin channel
     *
     * @param resource $stdin
     *            The channel
     * @return \Nkey\Caribu\Console\CLI
     */
    public function setStdIn($stdin): CLI
    {
        $this->stdin = $stdin;
        return $this;
    }

    /**
     * Set a custom stdout channel
     *
     * @param resource $stdout
     *            The channel
     * @return \Nkey\Caribu\Console\CLI
     */
    public function setStdOut($stdout): CLI
    {
        $this->stdout = $stdout;
        return $this;
    }

    /**
     * Set a custom stderr channel
     *
     * @param resource $stderr
     *            The channel
     * @return \Nkey\Caribu\Console\CLI
     */
    public function setStdErr($stderr): CLI
    {
        $this->stderr = $stderr;
        return $this;
    }

    /**
     * Read full line from stdin
     *
     * @return ParsedCommand The parsed command
     */
    public function readLine(): ParsedCommand
    {
        $this->writeStdout(sprintf("%s > ", $this->prompt));
        $input = stream_get_line($this->stdin, 4096, PHP_EOL);
        return $this->parser->parse(trim($input));
    }

    /**
     * Write output to stdout channel
     *
     * @param string $output
     *            The output to write
     *            
     * @return \Nkey\Caribu\Console\CLI Fluent interface instance
     */
    public function writeStdout(string $output): CLI
    {
        fprintf($this->stdout, "%s", $output);
        fflush($this->stdout);
        return $this;
    }

    /**
     * Write a line to stdout channel
     *
     * @param string $line
     *            The line to write, line break will be added
     *            
     * @return \Nkey\Caribu\Console\CLI
     */
    public function writeStdoutLine(string $line): CLI
    {
        $this->writeStdout(sprintf("%s%s", $line, PHP_EOL));
        return $this;
    }

    /**
     * Write a line to stderr channel
     *
     * @param string $line
     *            The line to write, line break will be added
     *            
     * @return \Nkey\Caribu\Console\CLI
     */
    public function writeStderrLine(string $line): CLI
    {
        $this->writeStderr(sprintf("%s%s", $line, PHP_EOL));
        return $this;
    }

    /**
     * Write output to stderr channel
     *
     * @param string $output
     *            The output to write
     *            
     * @return \Nkey\Caribu\Console\CLI Fluent interface instance
     */
    public function writeStderr(string $output): CLI
    {
        fprintf($this->stderr, "%s", $output);
        fflush($this->stderr);
        return $this;
    }

    /**
     * Set the prompt
     *
     * @param string $prompt
     *            The prompt to set
     *            
     * @return \Nkey\Caribu\Console\CLI Fluent interface instance
     */
    public function setPrompt(string $prompt): CLI
    {
        $this->prompt = $prompt;
        return $this;
    }
}
