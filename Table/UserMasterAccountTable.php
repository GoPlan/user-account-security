<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:19 PM
 */

namespace CreativeDelta\UserAccountSecurity\Table;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccount;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;

class UserMasterAccountTable
{
    protected $tableGateway;
    protected $hydrator;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->hydrator = new ClassMethods(false);
    }

    public function getUserMasterAccountById($id)
    {
        $rows = $this->tableGateway->select(array('id' => $id));
        return $rows->current();
    }

    public function getUserMasterAccountByEmail($email)
    {
        $rows = $this->tableGateway->select(array('email' => $email));
        return $rows->current();

    }

    public function save(UserMasterAccount $userMasterAccount)
    {
        $data = $this->hydrator->extract($userMasterAccount);
        $this->tableGateway->update($data, array('id' => $userMasterAccount->getId()));
    }

    public function create(UserMasterAccount $userMasterAccount)
    {
        $data = $this->hydrator->extract($userMasterAccount);
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }
}