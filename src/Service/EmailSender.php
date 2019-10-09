<?php
namespace App\Service;

class EmailSender
{
    private $adminEmail;

    public function __construct($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function sendEmail()
    {
        echo 'Send an email to ' . $this->adminEmail;
    }
}
