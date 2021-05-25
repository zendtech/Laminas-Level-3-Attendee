<?php
namespace PrivateMessages\Controller;

use Login\Model\User;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Traits\BlockCipherTrait;
use PrivateMessages\Model\ {Message, MessagesTable};

use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{

    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const SEND_SUCCESS   = '<b style="color:green;">Message sent successfully</b>';
    const SEND_FAIL      = '<b style="color:red;">Unable to send message</b>';
    const SEND_START     = '<b style="color:gray;">Press "SEND" when ready to send a new message</b>';

    protected $table;
    protected $sendForm;
    protected $authService;
    protected $message;
    protected $user;        // populated by IndexControllerFactory from auth service

    public function indexAction()
    {
        $from = $this->sendForm->get('fromEmail');
        $from->setAttribute('value', $this->user->getEmail());
        //*** to use this plugin, install it: "composer require laminas/laminas-mvc-plugin-flashmessenger"
        $status = $this->flashMessenger()->getMessages();
        return $this->setViewModel($status);
    }
    public function sendAction()
    {
        $status = self::SEND_START;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->sendForm->bind(new Message());
            $this->sendForm->setData($request->getPost());
            if (!$this->sendForm->isValid()) {
                $status = self::FORM_INVALID;
            } else {
                $message = $this->sendForm->getData();
                if ($this->table->save($message)) {
                    $status = self::SEND_SUCCESS;
                    $this->redirect()->toRoute('messages');
                } else {
                    $status = self::SEND_FAIL . '<br>' . implode('<br>', $this->sendForm->getMessages());
                }
            }
        }
        //*** to use this plugin, install it: "composer require laminas/laminas-mvc-plugin-flashmessenger"
        $this->flashMessenger()->addMessage($status);
        return $this->setViewModel($status);
    }
    protected function setViewModel($status)
    {
        $htmlStatus = '';
        if ($status) {
            $htmlStatus .= '<ul>';
            if (is_array($status)) {
                $htmlStatus .= '<li>' . implode('</li><li>', $status) . '</li>';
            } else {
                $htmlStatus .= '<li>' . $status . '</li>';
            }
            $htmlStatus .= '</ul>';
        }
        $viewModel = new ViewModel(
            [
                'identity' => $this->user,
                'sendForm' => $this->sendForm,
                'sentMessages' => $this->table->findMessagesSent($this->user->getEmail()),
                'receivedMessages' => $this->table->findMessagesReceived($this->user->getEmail()),
                'status' => $htmlStatus,
                //*** ADVANCED VIEW::I18N LAB: assign locale to the view
            ]
        );
        $viewModel->setTemplate('private-messages/index/index');
        return $viewModel;
    }
    public function setTable(MessagesTable $table)
    {
        $this->table = $table;
    }
    public function setSendForm(SendForm $form)
    {
        $this->sendForm = $form;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
}
