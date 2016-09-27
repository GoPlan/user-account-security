<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 8:13 PM
 */

namespace CreativeDelta\UserAccountSecurity\Model;


use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceInterface;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountStateActionInterface;

class UserMasterAccountNewState extends UserMasterAccountAbstractState implements UserMasterAccountStateActionInterface
{
    protected static $STATE_NAME = 'new';

    public function action(UserMasterAccountServiceInterface $userAccountService)
    {
        $this->getUserMasterAccount()->setState(UserMasterAccountNewState::$STATE_NAME);
        $this->getUserMasterAccount()->setConfig(null);
        $this->getUserMasterAccount()->setCreationDate(date('Y-m-d H:i:s'));

        $newId = $userAccountService->create($this->getUserMasterAccount());
        $this->getUserMasterAccount()->setId($newId);
//        $userAccountService->notify($this->getUserMasterAccount(), $this->prepareMessage());
    }

    private function prepareMessage()
    {

    }
}