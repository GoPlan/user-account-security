<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:58 PM
 */

namespace CreativeDelta\UserAccountSecurity\Service;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccount;
use CreativeDelta\UserAccountSecurity\Model\UserPasswordResetNotification;
use CreativeDelta\UserAccountSecurity\Table\UserMasterAccountTable;
use UserNotification\Service\EmailServiceInterface;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use Zend\Mime\Part;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class UserMasterAccountServiceDefault implements UserMasterAccountServiceInterface
{
    protected $userMasterAccountTable;
    protected $serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator, UserMasterAccountTable $userMasterAccountTable)
    {
        $this->userMasterAccountTable = $userMasterAccountTable;
        $this->serviceLocator = $serviceLocator;
    }

    public function getUserMasterAccountById($id)
    {
        return $this->userMasterAccountTable->getUserMasterAccountById($id);
    }

    public function getUserMasterAccountByEmail($email)
    {
        return $this->userMasterAccountTable->getUserMasterAccountByEmail($email);
    }

    public function create(UserMasterAccount $userMasterAccount)
    {
        return $this->userMasterAccountTable->create($userMasterAccount);
    }

    public function update(UserMasterAccount $userMasterAccount)
    {
        $this->userMasterAccountTable->save($userMasterAccount);
    }

    public function notify(UserMasterAccount $userMasterAccount, UserPasswordResetNotification $notification = null)
    {
        if (!$notification)
            return;

        try {

            /** @var PhpRenderer $viewRenderer */
            $viewRenderer = $this->serviceLocator->get('ViewRenderer');
            $content = $viewRenderer->render($notification->getViewModel());

            $body = new Part();
            $body->setType(Mime::TYPE_HTML);
            $body->setContent($content);

            $mimeMessage = new MimeMessage();
            $mimeMessage->setParts(array($body));

            /** @var Message $message */
            $message = $notification->getMessage();
            $message->setFrom('admin@mekong-cybernetic.vn');
            $message->setBody($mimeMessage);

            /** @var EmailServiceInterface $userNotificationEmailService */
            $userNotificationEmailService = $this->serviceLocator->get('UserNotification\Service\EmailServiceInterface');
            $userNotificationEmailService->send($message);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}