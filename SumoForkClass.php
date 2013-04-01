<?php
namespace SumoCoders\SumoForkClass;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
}
