<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 1:30 PM
 */

namespace CreativeDelta\UserAccountSecurity\Factory;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountPassword;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountPasswordServiceDefault;
use CreativeDelta\UserAccountSecurity\Table\UserMasterAccountPasswordTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMasterAccountPasswordServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AdapterInterface $dbAdapter */
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

        $hydrator = new HydratingResultSet(new ClassMethods(false), new UserMasterAccountPassword());
        $tableGateway = new TableGateway('UserMasterAccount', $dbAdapter, null, $hydrator);
        $userMasterAccountTable = new UserMasterAccountPasswordTable($tableGateway);

        return new UserMasterAccountPasswordServiceDefault($userMasterAccountTable);
    }
}