<?php

namespace SmsSend;

/**
 * SMS sender class
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Sms extends \Ease\Sand
{
    /**
     *
     * @var long
     */
    public $number;

    /**
     *
     * @var string
     */
    private $message;

    /**
     *
     * @var boolean
     */
    public $sent = false;

    /**
     *
     * @param long $number
     * @param string $message
     */
    public function __construct($number = null, $message = null)
    {
        if (!empty($number)) {
            $this->setNumber($number);
        }
        if (!empty($message)) {
            $this->setMessage($message);
        }
        if (!empty($this->message) && !empty($this->number)) {
            $this->sendMessage();
        }
    }

    /**
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $number = str_replace([' ', '.', '+'], ['', '', ''], $number);
        $number = preg_replace('/(420|0420)/', '', $number);
        $this->number = $number;
        $this->sent = false;
    }

    /**
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = /* \Ease\Functions::rip */($message);
        $this->sent = false;
    }

    /**
     * Current message text
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Current phone number
     *
     * @return long
     */
    public function getNumber()
    {
        return \Ease\Shared::cfg('DEBUG') ? \Ease\Shared::cfg('SMS_SENDER') : $this->number;
    }

    /**
     * Perform message sending
     * @return boolean
     */
    public function sendMessage()
    {
        $status = false;
        if (empty(\Ease\Shared::cfg('MODEM_PASSWORD'))) {
            if (\Ease\Shared::cfg('DEBUG')) {
                $this->addStatusMessage('Please set MODEM_PASSWORD (optionally MODEM_IP) to send SMS messages', 'warning');
            }
        } else {
            try {
                $router = new \HSPDev\HuaweiApi\Router();
                $router->setAddress(\Ease\Shared::cfg('MODEM_IP') ? \Ease\Shared::cfg('MODEM_IP') : '192.168.8.1');
                $router->login(\Ease\Shared::cfg('MODEM_USERNAME'), \Ease\Shared::cfg('MODEM_PASSWORD'));
                $status = $router->sendSms($this->getNumber(), $this->getMessage());
                $this->sent = true;
            } catch (\Exception $ex) {
                $status = $ex->getMessage();
                $this->addStatusMessage($status, 'error');
            }
        }
        $this->addStatusMessage('SMS ' . $this->getNumber() . ': ' . $this->getMessage(), $status ? 'success' : 'error');
        return $status;
    }
}
