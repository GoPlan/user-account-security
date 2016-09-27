<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 3:07 PM
 */

namespace CreativeDelta\UserAccountSecurity\Service;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccount;
use CreativeDelta\UserAccountSecurity\Model\UserPasswordResetNotification;

interface UserMasterAccountServiceInterface
{
    public function getUserMasterAccountById($id);

    public function getUserMasterAccountByEmail($email);

    public function create(UserMasterAccount $userMasterAccount);

    public function update(UserMasterAccount $userMasterAccount);

    public function notify(UserMasterAccount $userMasterAccount, UserPasswordResetNotification $notification);
}