<?php
namespace SumoCoders\SumoForkClass;

use Symfony\Component\DependencyInjection\ContainerInterface;
use SumoCoders\SumoForkClass\Errbit\ErrorHandler;

class SumoForkClass
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

	/**
	 * Debug-mode?
	 *
	 * @var bool
	 */
	private $debug = false;

	/**
	 * Errbit Api key
	 *
	 * @var string
	 */
	private $errbitApiKey;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

	/**
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

	/**
	 * @param boolean $debug
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;
	}

	/**
	 * @return boolean
	 */
	public function getDebug()
	{
		return $this->debug;
	}

	/**
	 * @param string $errbitApiKey
	 */
	public function setErrbitApiKey($errbitApiKey)
	{
		$this->errbitApiKey = $errbitApiKey;
	}

	/**
	 * @return string
	 */
	public function getErrbitApiKey()
	{
		return $this->errbitApiKey;
	}

    /**
     * Init method
     */
    public function init()
    {
        $this->initErrbit();
    }

    /**
     * Initialize Errbit
     */
    public function initErrbit()
    {
	    if(!$this->errbitApiKey && $this->container) {
		    try {
			    $this->debug = $this->getContainer()->getParameter('fork.debug');
			    $this->errbitApiKey = $this->getContainer()->getParameter('sumo.errbit_api_key');
	        } catch (\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException $e) {
			    // do nothing
		    }
	    }

        // only activate the error handler when we aren't in debug-mode and an api key is provided
        if (!$this->debug && $this->errbitApiKey != '') {
            \Errbit::instance()->configure(
                array(
                    'api_key' => $this->errbitApiKey,
                    'host' => 'errors.sumocoders.be',
                    'secure' => true,
                    'port' => 443,
                )
            );
            new Errbit\ErrorHandler();
        }
	}
}
