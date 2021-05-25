<?php
//*** EMAIL LAB: complete missing parts
namespace Notification\Listener;

use Application\Traits\ServiceContainerTrait;
use Notification\Event\NotificationEvent;
use Laminas\EventManager\ {EventInterface, EventManagerInterface,AbstractListenerAggregate};
use Laminas\Mail\Message;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mail\Transport\File;
use Laminas\Mail\Transport\FileOptions;
use Laminas\Mail\Transport\SendMail;

class Aggregate extends AbstractListenerAggregate
{

    use ServiceContainerTrait;

    public function attach(EventManagerInterface $e, $priority = 100)
    {
		//*** EMAIL LAB: attach listener using the shared manager
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', NotificationEvent::EVENT_NOTIFICATION, [$this, 'sendEmail'], $priority);
    }
    public function sendEmail(EventInterface $e)
    {
        try {
            // get config from event $e
            $config = $e->getParam('notify-config');
            // set up ViewModel and template for rendering
            $viewModel = new ViewModel();
            // throw exception if "to" is not set
            if (!isset($config['email-options']['to'])) {
                throw new Exception(self::ERROR_NO_RECIPIENT);
            }
            // create HTML body
            $html = new MimePart($e->getParam('message'));
            $html->type = Mime::TYPE_HTML;
            $html->charset = 'utf-8';
            $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
            $html->type = 'text/html';
            $body = new MimeMessage();
            $body->setParts([$html]);
            // set up mail message
            $message  = new Message();
            $message->addTo($config['email-options']['to']);
            $message->addFrom($config['email-options']['from']);
            // "cc" and "bcc" are optional
            if (isset($config['email-options']['cc']))
                $message->addCc($config['email-options']['cc']);
            if (isset($config['email-options']['bcc']))
                $message->addBcc($config['email-options']['bcc']);
            $message->setSubject($config['email-options']['subject']);
            $message->setBody($body);
            $message->setEncoding('UTF-8');
            // get transport
            switch ($config['email-options']['transport']) {
                case 'smtp' :
                    $transport = $this->serviceManager->get('email-notification-transport-smtp');
                    break;
                case 'file' :
                    $transport = $this->serviceManager->get('email-notification-transport-file');
                    break;
                default :
                    $transport = $this->serviceManager->get('email-notification-transport-sendmail');
            }
            // send
            NotifyEvent::$success = TRUE;
            $transport->send($message);
        } catch (Exception $e) {
            error_log(__METHOD__ . ':' . __LINE__ . ':' . self::ERROR_SENDING . $config['email-options']['to'] . ':' . $e->getMessage());
            NotificationEvent::$success = FALSE;
        }
    }
}
