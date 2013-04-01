<?php
namespace SumoCoders\SumoForkClass\Errbit;

class Error
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $line;

    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $trace;

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * Create a new error wrapping the given error context info.
     */
    public function __construct($message, $line, $file, $trace = null)
    {
        $this->setMessage($message);
        $this->setLine($line);
        $this->setFile($file);
        $this->setTrace($trace);
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param int $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        if (!isset($this->parameters['_POST']) && !empty($_POST)) {
            $this->parameters['_POST'] = $_POST;
        }
        if (!isset($this->parameters['_GET']) && !empty($_GET)) {
            $this->parameters['_GET'] = $_GET;
        }
        if (!isset($this->parameters['_COOKIE']) && !empty($_COOKIE)) {
            $this->parameters['_COOKIE'] = $_COOKIE;
        }
        if (!isset($this->parameters['_SESSION']) && !empty($_SESSION)) {
            $this->parameters['_SESSION'] = $_SESSION;
        }

        return $this->parameters;
    }

    /**
     * @param array $trace
     */
    public function setTrace($trace = null)
    {
        if ($trace === null) {
            $trace = array(
                array(
                    'line' => $this->getLine(),
                    'file' => $this->getFile(),
                    'function' => 'unknown'
                )
            );
        }
        $this->trace = $trace;
    }

    /**
     * @return array
     */
    public function getTrace()
    {
        return $this->trace;
    }
}
