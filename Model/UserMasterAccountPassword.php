<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/25/16
 * Time: 10:17 AM
 */

namespace CreativeDelta\UserAccountSecurity\Model;

class UserMasterAccountPassword
{
    protected $identity;
    protected $password;
    protected $config;

    public function __construct()
    {
        $this->identity = new UserMasterIdentity();
    }

    /**
     * @return UserMasterIdentity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->identity->getUsername();
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->identity->setUsername($username);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->identity->getId();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->identity->setId($id);
    }

    public function getRole()
    {
        return $this->getIdentity()->getRole();
    }

    public function setRole($role)
    {
        return $this->getIdentity()->setRole($role);
    }

    public function getEmail()
    {
        return $this->getIdentity()->getEmail();
    }

    public function setEmail($email)
    {
        $this->getIdentity()->setEmail($email);
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->identity->getState();
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->identity->setState($state);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}