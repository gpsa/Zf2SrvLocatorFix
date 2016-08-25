<?php
/*
 * Script criado em 25/08/2016.
 */
namespace Gpsa\Zf2SrvLocatorFix\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of AbstractActionController
 *
 * @author Guilherme Alves <guilherme.alves@solutinet.com.br>
 */
class AbstractActionController extends ZendAbstractActionController
{

    private $serviceLocatorSetByFactory = false;

    public function setServiceLocatorByFactory(ServiceLocatorInterface $sm)
    {
        $this->serviceLocator = $sm;
        $this->serviceLocatorSetByFactory = true;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if ($this->serviceLocatorSetByFactory === true) {
            return $this->serviceLocator;
        }
        return parent::getServiceLocator();
    }
}
