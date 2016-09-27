<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 11:28 AM
 */

namespace CreativeDelta\UserAccountSecurity\Service;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountPassword;

interface UserMasterAccountPasswordServiceInterface
{
    public function getUserMasterAccountPasswordById($id);

    public function getUserMasterAccountPasswordByUsername($username);

    public function getUserMasterAccountPasswordByEmail($email);

    public function verifyPassword($rawPassword, UserMasterAccountPassword $masterAccountPassword);

    public function changePassword($rawPassword, UserMasterAccountPassword $masterAccountPassword);
}