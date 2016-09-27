<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/26/16
 * Time: 8:22 AM
 */

namespace CreativeDelta\UserAccountSecurity\Adapter;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountPassword;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountPasswordServiceInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Hydrator\ClassMethods;

class UserTemporaryPasswordAuthenticationAdapter implements AdapterInterface
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

    public function verify($username, $hashedString)
    {
        /** @var UserMasterAccountPassword $userMasterAccountPassword */
        $userMasterAccountPassword = $this->userMasterAccountPasswordService->getUserMasterAccountPasswordByUsername($username);

        // VALIDATION
        if (!$userMasterAccountPassword) {

            $this->result = new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null);

        } else {

            // RETRIEVE CONFIGS
            $config = json_decode($userMasterAccountPassword->getConfig());
            $expiration = date_create_from_format('Y-m-d H:i:s', $config->expiration);
            $password = $config->password;
            $this->bcrypt->setSalt($config->salt);
            $now = new \DateTime();

            // TOKEN EXPIRATION REMAIN
            $interval = $now->diff($expiration);

            if ($interval->s > 0 && !$interval->invert) {

                if ($this->bcrypt->verify($password, $hashedString)) {

                    $this->result = new Result(Result::SUCCESS, $userMasterAccountPassword->getIdentity());

                } else {

                    $this->result = new Result(Result::FAILURE_CREDENTIAL_INVALID, null);

                }

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