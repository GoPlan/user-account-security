<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 4:37 PM
 */

namespace CreativeDelta\UserAccountSecurity\Controller;


use CreativeDelta\UserAccountSecurity\Model\UserMasterIdentity;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class SecuredActionController extends AbstractActionController
{
    private static $SIGNIN_ROUTE = 'user-sign-in';

    /** @var  AuthenticationServiceInterface $authenticationService */
    protected $authenticationService;

    /**
     * @return AuthenticationServiceInterface
     */
    public function getAuthenticationService()
    {
        if (!$this->authenticationService) {
            $this->authenticationService = new AuthenticationService();
        }

        return $this->authenticationService;
    }

    /**
     * @param mixed $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return  UserMasterIdentity
     */
    public function getIdentity()
    {
        return $this->getAuthenticationService()->getIdentity();
    }

    public function hasActiveIdentity()
    {
        /** @var bool $hasIdentity */
        $hasIdentity = $this->getAuthenticationService()->hasIdentity();

        /** @var UserMasterIdentity $identity */
        $identity = $this->getAuthenticationService()->getIdentity();
        $state = $identity ? $identity->getState() : "";

        return $hasIdentity && $state == UserMasterIdentity::$STATE_ACTIVE;
    }

    public function redirectToSignIn()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $returnUrl = $request->getUriString();
        return $this->redirect()->toRoute(SecuredActionController::$SIGNIN_ROUTE, array(), array('query' => array('return-url' => $returnUrl)));
    }
}