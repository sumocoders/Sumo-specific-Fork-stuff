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
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface[optional] $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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
        try {
            $debug = $this->getContainer()->getParameter('fork.debug');
            $errbitApiKey = $this->getContainer()->getParameter('sumo.errbit_api_key');

            // only activate the error handler when we aren't in debug-mode and an api key is provided
            if (!$debug && $errbitApiKey != '') {
                \Errbit::instance()->configure(
                    array(
                        'api_key' => $errbitApiKey,
                        'host' => 'errors.sumocoders.be',
                        'secure' => true,
                        'port' => 443,
                    )
                );
                new Errbit\ErrorHandler();
            }
        } catch (\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException $e) {
            // do nothing
        }
    }
}
