<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:57 PM
 */

namespace CreativeDelta\UserAccountSecurity\Factory;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccount;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceDefault;
use CreativeDelta\UserAccountSecurity\Table\UserMasterAccountTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMasterAccountServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AdapterInterface $adapter */
        $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

        /** @var ResultInterface $resultSetPrototype */
        $resultSetPrototype = new HydratingResultSet(new ClassMethods(false), new UserMasterAccount());

        /** @var TableGateway $tableGateway */
        $tableGateway = new TableGateway('UserMasterAccount', $adapter, null, $resultSetPrototype);

        /** @var UserMasterAccountTable $table */
        $table = new UserMasterAccountTable($tableGateway);

        return new UserMasterAccountServiceDefault($serviceLocator, $table);
    }
}