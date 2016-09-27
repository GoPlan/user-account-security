<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 12:26 PM
 */

namespace CreativeDelta\UserAccountSecurity\Adapter;


use CreativeDelta\CreativeDelta\UserAccountSecurity\Model\UserMasterAccountPassword;
use CreativeDelta\CreativeDelta\UserAccountSecurity\Model\UserMasterIdentity;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountPasswordServiceInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Hydrator\ClassMethods;

class UserMasterAccountAuthenticationAdapter implements AdapterInterface
{

    protected $userMasterAccountPasswordService;
    protected $bcrypt;
    protected $hydrator;
    protected $result;

    public function __construct(UserMasterAccountPasswordServiceInterface $userMasterAccountPasswordService)
    {
        $this->userMasterAccountPasswordService = $userMasterAccountPasswordService;
        $this->hydrator = new ClassMethods(false);
        $this->bcrypt = new Bcrypt();
    }

    public function verify($username, $password)
    {
        /** @var UserMasterAccountPassword $userMasterAccountPassword */
        $userMasterAccountPassword = $this->userMasterAccountPasswordService->getUserMasterAccountPasswordByUsername($username);

        if (!$userMasterAccountPassword || $userMasterAccountPassword->getState() != UserMasterIdentity::$STATE_ACTIVE) {

            $this->result = new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null);

        } else {

            if ($this->bcrypt->verify($password, $userMasterAccountPassword->getPassword())) {

                $this->result = new Result(Result::SUCCESS, $userMasterAccountPassword->getIdentity());

            } else {

                $this->result = new Result(Result::FAILURE, null);

            }
        }
    }

    public function authenticate()
    {
        return $this->result;
    }

}