<?php
namespace Login\Controller;

use Login\Event\LoginEvent;
use Login\Model\UsersTable;
use Login\Form\ {Login as LoginForm, Register as RegForm};
use Login\Traits\AuthServiceTrait;

use Model\Entity\User;
use Model\Traits\UsersTableTrait;
use Translation\Listener\Event;

use Laminas\Log\Logger;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    const LOGIN_INIT      = '<b style="color:gray;">Please requested login information</b>';
    const LOGIN_SUCCESS   = '<b style="color:green;">Login was successful</b>';
    const LOGIN_FAIL      = '<b style="color:red;">Login failed</b>';
    const FORM_INVALID    = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const EVENT_SOMETHING = 'logging-log-something';

    use UsersTableTrait;
    use AuthServiceTrait;

    protected $loginForm;

    public function indexAction()
    {
        return new ViewModel(['loginForm' => $this->loginForm,
                              'message' => '']);
    }
    /**
     * Performs basic login / authentication
     *
     * Additional security suggestions:
     * #1: create a log file of successful and failed login attempts
     * #2: maintain a counter and redirect at random if XXX number of failed login attempts
     *
     */
    public function loginAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->loginForm->bind(new User());
            $this->loginForm->setData($request->getPost());
            if (!$this->loginForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $user = $this->loginForm->getData();
                $adapter = $this->authService->getAdapter();
                //*** LDAP LAB: trigger an event here and pass $adapter as a parameter
                $adapter->setIdentity($user->getEmail());
                $adapter->setCredential($user->getPassword());
                $result = $adapter->authenticate();
                if ($result->isValid()) {
                    //*** TRANSLATION LAB: reset locale based on login params
                    $locale = $user->getLocale();  // comes from login form data
                    //*** SECURITY::LDAP LAB: add a "switch" statement which accounts for different result objects (i.e. database or LDAP)
                    $obj = $adapter->getResultRowObject(NULL, ['password']);
                    // getResultRowObject() returns a stdClass instance ... need to hydrate into a User instance
                    $user = new User((array) $obj);
                    $user->setLocale($locale);  // reset locale from login form data
                    $storage = $this->authService->getStorage();
                    $storage->write($user);
                    // success notification and logging
                    $this->flashMessenger()->addMessage(self::LOGIN_SUCCESS);
                    $this->logMessage(Logger::INFO, self::LOGIN_SUCCESS . ':' . $user->getEmail());
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::LOGIN_FAIL . '<br>' . implode('<br>', $result->getMessages());
                    $this->logMessage(Logger::WARN, $message);
                }
            }
            //*** to use this plugin, install it: "composer require laminas/laminas-mvc-plugin-flashmessenger"
            $this->flashMessenger()->addMessage($message);
        }
        $message = $message ?: implode('<br>', $this->flashMessenger()->getMessages());
        $viewModel = new ViewModel(['loginForm' => $this->loginForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        $this->getEventManager()->trigger(LoginEvent::EVENT_LOGIN_VIEW, $this, ['viewModel' => $viewModel]);
        return $viewModel;
    }
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        return $this->loginAction();
    }
    public function setLoginForm(LoginForm $form)
    {
        $this->loginForm = $form;
    }
    protected function logMessage($level, $message)
    {
		$this->getEventManager()
		     ->trigger( self::EVENT_SOMETHING, 
						$this, 
						['level' => Logger::INFO, 'message' => $message]
		);
	}
}
