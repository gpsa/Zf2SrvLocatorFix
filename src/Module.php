<?php namespace Gpsa\Zf2SrvLocatorFix;

use Zend\Memory\Container\ContainerInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/*
 * Script criado em 25/08/2016.
 */

/**
 * Description of Module
 *
 * @author Guilherme Alves <guilherme.alves@solutinet.com.br>
 */
class Module
{

    public function getServiceConfig()
    {
        return array(
            'initializers' => [
                'ServiceLocatorAwareInitializer' => function ($first, $second) {
                    if ($first instanceof AbstractPluginManager) {
                        // Edge case under zend-servicemanager v2
                        $container = $second;
                        $instance = $first;
                    } elseif ($first instanceof ContainerInterface) {
                        // zend-servicemanager v3
                        $container = $first;
                        $instance = $second;
                    } else {
                        // zend-servicemanager v2
                        $container = $second;
                        $instance = $first;
                    }
                    // For service locator aware classes, inject the service
                    // locator, but emit a deprecation notice. Skip plugin manager
                    // implementations; they're dealt with later.
                    if ($instance instanceof ServiceLocatorAwareInterface && !$instance instanceof AbstractPluginManager) {
                        // trigger_error(sprintf('ServiceLocatorAwareInterface is deprecated and will be removed in version 3.0, along ' . 'with the ServiceLocatorAwareInitializer. Please update your class %s to remove ' . 'the implementation, and start injecting your dependencies via factory instead.', get_class($instance)), E_USER_DEPRECATED);
                        $instance->setServiceLocator($container);
                    }
                    // For service locator aware plugin managers that do not have
                    // the service locator already injected, inject it, but emit a
                    // deprecation notice.
                    if ($instance instanceof ServiceLocatorAwareInterface && $instance instanceof AbstractPluginManager && !$instance->getServiceLocator()) {
                        // trigger_error(sprintf('ServiceLocatorAwareInterface is deprecated and will be removed in version 3.0, along ' . 'with the ServiceLocatorAwareInitializer. Please update your %s plugin manager factory ' . 'to inject the parent service locator via the constructor.', get_class($instance)), E_USER_DEPRECATED);
                        $instance->setServiceLocator($container);
                    }
                },
            ]
        );
    }
}
