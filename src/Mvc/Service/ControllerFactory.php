<?php namespace Gpsa\Zf2SrvLocatorFix\Mvc\Service;

/*
 * Script criado em 25/08/2016.
 */

use Exception;
use Gpsa\Zf2SrvLocatorFix\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of DoNotUseMeControllerFactory
 *
 * @author Guilherme Alves <guilherme.alves@solutinet.com.br>
 */
class ControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $sm)
    {
        if (func_num_args() !== 3) {
            throw new Exception('arguments cound changed too: ' . func_num_args());
        }
        $args = func_get_args();
        $serviceName = $args[1];
        $className = $args[2] . 'Controller';
        /* @var $controller \YOUR_SPACE\Mvc\Controller\AbstractActionController */
        $controller = new $className();
        if (!$controller instanceof AbstractActionController) {
            throw new Exception(get_class($controller) . ' must be an instanceof AbstractActionController');
        }
        $controller->setServiceLocatorByFactory($sm);
        return $controller;
    }
}
