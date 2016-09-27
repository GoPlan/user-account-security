<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 3:03 PM
 */

namespace CreativeDelta\UserAccountSecurity\Model;


use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceInterface;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountStateActionInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\View\Model\ViewModel;

class UserMasterAccountTemporaryState extends UserMasterAccountAbstractState implements UserMasterAccountStateActionInterface
{
    protected static $SECURITY_STRING_LENGTH = 8;
    protected static $STATE_NAME = 'temporary';
    protected $bcrypt;

    /**
     * @return Bcrypt
     */
    public function getBcrypt()
    {
        if (!$this->bcrypt) {
            $this->bcrypt = new Bcrypt();
        }

        return $this->bcrypt;
    }

    public function action(UserMasterAccountServiceInterface $userAccountService)
    {
        $config = $this->prepareConfig();
        $notification = $this->prepareNotification($config);

        $this->getUserMasterAccount()->setState(UserMasterAccountTemporaryState::$STATE_NAME);
        $this->getUserMasterAccount()->setConfig(json_encode($config));
        $this->getUserMasterAccount()->setModifiedDate(date('Y-m-d H:i:s'));
        $this->getUserMasterAccount()->setDisabledDate(null);

        try {
            $userAccountService->update($this->getUserMasterAccount());
            $userAccountService->notify($this->getUserMasterAccount(), $notification);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    protected function prepareConfig()
    {
        $random_password = bin2hex(openssl_random_pseudo_bytes(UserMasterAccountTemporaryState::$SECURITY_STRING_LENGTH));
        $random_salt = bin2hex(openssl_random_pseudo_bytes(UserMasterAccountTemporaryState::$SECURITY_STRING_LENGTH));
        $expiry_datetime = new \DateTime();
        date_add($expiry_datetime, \DateInterval::createFromDateString('3 minutes'));

        $this->getBcrypt()->setSalt($random_salt);
        $hashed = $this->getBcrypt()->create($random_password);

        $config = array(
            'password' => $random_password,
            'salt' => $random_salt,
            'hashed' => $hashed,
            'expiration' => $expiry_datetime->format('Y-m-d H:i:s')
        );

        return $config;
    }

    protected function prepareNotification($config)
    {
        $view = new ViewModel(array(
            'username' => $this->getUserMasterAccount()->getUsername(),
            'config' => $config
        ));

        $view->setTemplate('reset-password-notification');

        $message = new Message();
        $message->setTo($this->getUserMasterAccount()->getEmail());
        $message->setSubject('Password Reset Notification');

        $notification = new UserPasswordResetNotification();
        $notification->setViewModel($view);
        $notification->setMessage($message);

        return $notification;
    }
}