<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 3:03 PM
 */

namespace CreativeDelta\UserAccountSecurity\Service;


interface UserMasterAccountStateActionInterface
{
    public function action(UserMasterAccountServiceInterface $userAccountService);
}