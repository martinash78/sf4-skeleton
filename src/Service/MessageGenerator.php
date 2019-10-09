<?php
namespace App\Service;

use mysql_xdevapi\Exception;
use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $logger;
    private $logPrefix;
    private $emailSender;
    private $adminEmail;

    public function __construct($emailSender, $logPrefix, LoggerInterface $logger, $adminEmail)
    {
        $this->logger = $logger;
        $this->logPrefix = $logPrefix;
        $this->emailSender = $emailSender;
        $this->adminEmail = $adminEmail;
    }

    public function getChuckMessage()
    {
        $response = file_get_contents('https://api.chucknorris.io/jokes/random');
        $obj = json_decode($response);
        $joke = $obj->value;
        $this->logger->info($this->logPrefix . $joke);
        return $joke;
    }
}
