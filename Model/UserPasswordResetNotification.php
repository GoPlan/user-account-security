<?php
/**
 * Created by PhpStorm.
 * User: ducanh-ki
 * Date: 7/26/16
 * Time: 12:10 PM
 */

namespace CreativeDelta\UserAccountSecurity\Model;


class UserPasswordResetNotification
{
    protected $viewModel;
    protected $message;

    /**
     * @return mixed
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param mixed $viewModel
     */
    public function setViewModel($viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


}