<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/24/16
 * Time: 4:16 PM
 */

namespace CreativeDelta\UserAccountSecurity\Controller;


use CreativeDelta\UserAccountSecurity\Model\UserMasterAccount;
use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountActiveState;
use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountNewState;
use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountDisableState;
use CreativeDelta\UserAccountSecurity\Model\UserMasterAccountTemporaryState;
use CreativeDelta\UserAccountSecurity\Service\UserMasterAccountServiceInterface;
use Zend\Http\Request;
use Zend\Hydrator\ClassMethods;
use Zend\View\Model\JsonModel;

class IndexController extends SecuredActionController
{
    protected $userMasterAccountService;
    protected $hydrator;

    public function __construct(UserMasterAccountServiceInterface $userMasterAccountService)
    {
        $this->userMasterAccountService = $userMasterAccountService;
        $this->hydrator = new ClassMethods(false);
    }

    public function createAction()
    {
        if (!$this->hasActiveIdentity()) {
            return $this->redirectToSignIn();
        }


        try {

            /** @var Request $request */
            $request = $this->getRequest();

            if (!$request->isPost()) {
                return new JsonModel();
            }

            $username = $this->params()->fromPost('username');
            $email = $this->params()->fromPost('email');
            $returnUrl = $this->params()->fromPost('return-url');

            $userMasterAccount = new UserMasterAccount();
            $userMasterAccount->setUsername($username);
            $userMasterAccount->setEmail($email);

            /** @var UserMasterAccountNewState $action */
            $action = $this->serviceLocator->get('CreativeDelta\UserAccountSecurity\Model\UserMasterAccountCreateState');
            $action->setUserMasterAccount($userMasterAccount);
            $action->action($this->userMasterAccountService);

            return $this->redirect()->toRoute('user-security-reset', array('id' => $userMasterAccount->getId()), array('query' => array('return-url' => $returnUrl)));

        } catch (\Exception $ex) {

            throw $ex;

        }
    }

    public function enableAction()
    {
        if (!$this->hasActiveIdentity()) {
            return $this->redirectToSignIn();
        }

        try {

            $id = $this->params('id');

            if (!$id) {
                return new JsonModel();
            }

            /** @var UserMasterAccount $userMasterAccount */
            $userMasterAccount = $this->userMasterAccountService->getUserMasterAccountById($id);

            if ($userMasterAccount) {
                /** @var UserMasterAccountActiveState $action */
                $action = $this->serviceLocator->get('CreativeDelta\UserAccountSecurity\Model\UserMasterAccountActiveState');
                $action->setUserMasterAccount($userMasterAccount);
                $action->action($this->userMasterAccountService);
            } else {
                throw new \Exception('User master account with id:' . $id . ' can not be found');
            }

            $returnUrl = $this->params()->fromQuery('return-url');

            if ($returnUrl) {
                return $this->redirect()->toUrl($returnUrl);
            } else {
                return new JsonModel($this->hydrator->extract($userMasterAccount));
            }

        } catch (\Exception $ex) {

            throw  $ex;

        }
    }

    public function disableAction()
    {
        if (!$this->hasActiveIdentity()) {
            return $this->redirectToSignIn();
        }

        try {

            $id = $this->params('id');

            if (!$id) {
                return new JsonModel();
            }

            /** @var UserMasterAccount $userMasterAccount */
            $userMasterAccount = $this->userMasterAccountService->getUserMasterAccountById($id);

            if ($userMasterAccount) {
                /** @var UserMasterAccountDisableState $action */
                $action = $this->serviceLocator->get('CreativeDelta\UserAccountSecurity\Model\UserMasterAccountDisabledState');
                $action->setUserMasterAccount($userMasterAccount);
                $action->action($this->userMasterAccountService);
            } else {
                throw new \Exception('User master account with id:' . $id . ' can not be found');
            }

            $returnUrl = $this->params()->fromQuery('return-url');

            if ($returnUrl) {
                return $this->redirect()->toUrl($returnUrl);
            } else {
                return new JsonModel($this->hydrator->extract($userMasterAccount));
            }

        } catch (\Exception $ex) {

            throw  $ex;

        }
    }

    public function resetAction()
    {
        try {

            $id = $this->params('id');
            $email = $this->params()->fromQuery('email');

            if (!$id && !$email) {
                return new JsonModel();
            }

            /** @var UserMasterAccount $userMasterAccount */
            $userMasterAccount = $id ? $this->userMasterAccountService->getUserMasterAccountById($id) : $this->userMasterAccountService->getUserMasterAccountByEmail($email);

            if ($userMasterAccount) {
                /** @var UserMasterAccountTemporaryState $action */
                $action = $this->serviceLocator->get('CreativeDelta\UserAccountSecurity\Model\UserMasterAccountTemporaryState');
                $action->setUserMasterAccount($userMasterAccount);
                $action->action($this->userMasterAccountService);
            } else {
                // TODO: Temporarily ignore error
            }

            $returnUrl = $this->params()->fromQuery('return-url');

            if ($returnUrl) {
                return $this->redirect()->toUrl($returnUrl);
            } else {
                return new JsonModel($this->hydrator->extract($userMasterAccount));
            }

        } catch (\Exception $ex) {

            throw  $ex;

        }
    }
}