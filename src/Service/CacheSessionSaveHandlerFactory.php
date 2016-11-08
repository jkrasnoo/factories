<?php

namespace Jkrasnoo\Factories\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SaveHandler\Cache;

class CacheSessionSaveHandlerFactory implements FactoryInterface
{
    protected $configKey = 'session_save_handler';

    /**
     * Instantiates the Cache Save Handler.
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return Cache
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $cache = null;
        $config = $container->get('config');
        if (!isset($config[$this->configKey]))
        {
            throw new ServiceNotCreatedException(
                'Cache session save handler requires ' . $this->configKey . ' to be set.'
            );
        }

        $adapterConfig = $config[$this->configKey]['adapter'];
        $cacheConfig = $adapterConfig['cache'];

        if (is_string($cacheConfig))
        {
            if (!$container->has($cacheConfig))
            {
                throw new ServiceNotCreatedException(sprintf(
                    'Cache service with the name %s not found.',
                    $cacheConfig
                ));
            }

            $cache = $container->get($cacheConfig);
        }

        return new Cache($cache);
    }

    /**
     * Creates the Cache Session Save Handler as a service.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, SaveHandlerInterface::class);
    }
}