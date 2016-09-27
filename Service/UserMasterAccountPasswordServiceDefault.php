<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 11:29 AM
 */

namespace CreativeDelta\UserAccountSecurity\Service;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountPassword;
use CreativeDelta\UserAccountSecurity\Table\UserMasterAccountPasswordTable;
use Zend\Crypt\Password\Bcrypt;

class UserMasterAccountPasswordServiceDefault implements UserMasterAccountPasswordServiceInterface
{
    protected $bcrypt;
    protected $userMasterAccountPasswordTable;

    public function __construct(UserMasterAccountPasswordTable $userMasterAccountPasswordTable)
    {
        $this->bcrypt = new Bcrypt();
        $this->userMasterAccountPasswordTable = $userMasterAccountPasswordTable;
    }

    public function verifyPassword($rawPassword, UserMasterAccountPassword $masterAccountPassword)
    {
        return $this->bcrypt->verify($rawPassword, $masterAccountPassword->getPassword());
    }

    public function changePassword($rawPassword, UserMasterAccountPassword $masterAccountPassword)
    {
        $hashedNewPassword = $this->hashPassword($rawPassword);
        return $this->userMasterAccountPasswordTable->updatePasswordById($masterAccountPassword->getId(), $hashedNewPassword, $masterAccountPassword->getState());
    }

    public function hashPassword($rawPassword)
    {
        return $this->bcrypt->create($rawPassword);
    }

    public function getUserMasterAccountPasswordById($id)
    {
        return $this->userMasterAccountPasswordTable->getUserMasterAccountPasswordById($id);
    }

    public function getUserMasterAccountPasswordByUsername($username)
    {
        return $this->userMasterAccountPasswordTable->getUserMasterAccountPasswordByUsername($username);
    }

    public function getUserMasterAccountPasswordByEmail($email)
    {
        return $this->userMasterAccountPasswordTable->getUserMasterAccountPasswordByEmail($email);
    }

}