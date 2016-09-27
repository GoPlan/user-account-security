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

class UserMasterAccountActiveState extends UserMasterAccountAbstractState implements UserMasterAccountStateActionInterface
{
    protected static $STATE_NAME = 'active';

    public function action(UserMasterAccountServiceInterface $userAccountService)
    {
        $this->getUserMasterAccount()->setState(UserMasterAccountActiveState::$STATE_NAME);
        $this->getUserMasterAccount()->setConfig(null);
        $this->getUserMasterAccount()->setModifiedDate(date('Y-m-d H:i:s'));
        $this->getUserMasterAccount()->setDisabledDate(null);

        $userAccountService->update($this->getUserMasterAccount());
    }

}