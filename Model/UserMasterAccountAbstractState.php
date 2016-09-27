<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:27 PM
 */

namespace CreativeDelta\UserAccountSecurity\Model;


abstract class UserMasterAccountAbstractState
{
    /** @var  UserMasterAccount */
    protected $userMasterAccount;

    /**
     * @return UserMasterAccount
     */
    public function getUserMasterAccount()
    {
        return $this->userMasterAccount;
    }

    /**
     * @param UserMasterAccount $userMasterAccount
     */
    public function setUserMasterAccount($userMasterAccount)
    {
        $this->userMasterAccount = $userMasterAccount;
    }
}