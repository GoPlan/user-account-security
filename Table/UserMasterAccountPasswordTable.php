<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 1:31 PM
 */

namespace CreativeDelta\UserAccountSecurity\Table;


use Zend\Db\Sql\Update;
use Zend\Db\TableGateway\TableGateway;

class UserMasterAccountPasswordTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getUserMasterAccountPasswordByUsername($username)
    {
        $rows = $this->tableGateway->select(array('username' => $username));
        return $rows->current();
    }

    public function getUserMasterAccountPasswordById($id)
    {
        $rows = $this->tableGateway->select(array('id' => $id));
        return $rows->current();
    }

    public function getUserMasterAccountPasswordByEmail($email)
    {
        $rows = $this->tableGateway->select(array('email' => $email));
        return $rows->current();
    }

    public function updatePasswordById($id, $newPassword, $newState)
    {
        $sql = new Update('UserMasterAccount');
        $sql->set(array('password' => $newPassword, 'state' => $newState));
        $sql->where(array('id' => $id));

        return $this->tableGateway->updateWith($sql);
    }
}

