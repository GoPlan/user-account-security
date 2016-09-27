<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:57 PM
 */

namespace CreativeDelta\UserAccountSecurity\Factory;


use CreativeDelta\UserAccountSecurity\Controller\IndexController;
use CreativeDelta\UserAccountSecurity\Table\UserMasterAccountTable;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $cm */
        $cm = $serviceLocator;

        /** @var ServiceManager $sm */
        $sm = $cm->getServiceLocator();

        /** @var UserMasterAccountTable $dataTable */
        $service = $sm->get('CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceInterface');

        return new IndexController($service);
    }
}