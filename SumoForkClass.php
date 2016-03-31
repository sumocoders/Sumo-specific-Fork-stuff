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
     * Should we ignore the notification on shutdown?
     *
     * @var bool
     */
    private $errbitIgnoreShutdown = false;

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
     * @param boolean $errbitIgnoreShutdown
     */
    public function setErrbitIgnoreShutdown($errbitIgnoreShutdown)
    {
        $this->errbitIgnoreShutdown = $errbitIgnoreShutdown;
    }

    /**
     * @return boolean
     */
    public function getErrbitIgnoreShutdown()
    {
        return $this->errbitIgnoreShutdown;
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
        if (!$this->errbitApiKey && $this->container) {
            try {
                if ($this->getContainer()->hasParameter('kernel.debug')) {
                    $this->debug = $this->getContainer()->getParameter('kernel.debug');
                } else {
                    $this->debug = $this->getContainer()->hasParameter('fork.debug');
                }
                $this->errbitApiKey = $this->getContainer()->getParameter('sumo.errbit_api_key');
            } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
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
                    'environment_name' => 'production'
                )
            );
            new Errbit\ErrorHandler($this->getErrbitIgnoreShutdown());
        }
    }
}
