<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:18 PM
 */

namespace CreativeDelta\UserAccountSecurity\Model;


use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceInterface;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountStateActionInterface;

class UserMasterAccountDisableState extends UserMasterAccountAbstractState implements UserMasterAccountStateActionInterface
{
    protected static $STATE_NAME = 'disabled';

    public function action(UserMasterAccountServiceInterface $userAccountService)
    {
        $this->getUserMasterAccount()->setState(UserMasterAccountDisableState::$STATE_NAME);
        $this->getUserMasterAccount()->setConfig(null);
        $this->getUserMasterAccount()->setModifiedDate(date('Y-m-d H:i:s'));
        $this->getUserMasterAccount()->setDisabledDate(date('Y-m-d H:i:s'));

        $userAccountService->update($this->getUserMasterAccount());
    }
}