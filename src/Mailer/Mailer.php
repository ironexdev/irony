<?php

namespace App\Mailer;

use App\Config\Config;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $swiftMailer;

    /**
     * Mailer constructor.
     */
    public function __construct()
    {
        $mailerConfig = Config::getMailer();

        $transport = new Swift_SmtpTransport($mailerConfig["host"], $mailerConfig["port"]);
        $transport->setUsername($mailerConfig["username"]);
        $transport->setPassword($mailerConfig["password"]);
        
        $this->swiftMailer = new Swift_Mailer($transport);
    }

    /**
     * @param $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array $attachments
     * @param array $cc
     * @param array $bcc
     */
    public function send($from, string $to, string $subject, string $body, array $attachments = [], array $cc = [], array $bcc = []): void
    {
        $message = new Swift_Message($subject);
        $message->setFrom($from);
        $message->setTo($to);
        $message->setBody($body, "text/html", "utf-8");
        $message->addPart(strip_tags(str_replace(["<br>", "<br/>", "<br />"], "\n", $body)), "text/plain", "utf-8");

        if($cc)
        {
            $message->setCc($cc);
        }

        if($bcc)
        {
            $message->setBcc($bcc);
        }

        foreach($attachments as $attachment)
        {
            $message->attach(Swift_Attachment::fromPath($attachment));
        }

        $this->swiftMailer->send($message);
    }
}