<?php
namespace Registration\Controller;

use Model\Entity\User;
use Model\Table\UsersTable;
use Model\Traits\UsersTableTrait;

use Registration\Form\RegForm;

use Zend\Log\Logger;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class RegController extends AbstractActionController
{

    const REG_SUCCESS     = '<b style="color:green;">Registration was successful</b>';
    const REG_FAIL        = '<b style="color:red;">Registration failed</b>';
    const EVENT_SOMETHING = 'logging-log-something';

    use UsersTableTrait;

    protected $regForm;

    public function indexAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->regForm->bind(new User());
            $this->regForm->setData($request->getPost());
            if (!$this->regForm->isValid()) {
                $message = self::REG_FAIL;
				//*** LOGGER LAB: log a warning message
                $this->logMessage(Logger::WARN, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->regForm->getMessages(), TRUE));
            } else {
                $user = $this->regForm->getData();
                if ($this->table->save($user)) {
					//*** LOGGER LAB: log an info message
					$this->logMessage(Logger::INFO, __METHOD__ . ':' . self::REG_SUCCESS . ':' . $user->getEmail());
                    $this->flashMessenger()->addMessage(self::REG_SUCCESS);
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::REG_FAIL . '<br>' . implode('<br>', $result->getMessages());
					//*** LOGGER LAB: log an error message
					$this->logMessage(Logger::ERROR, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->regForm->getMessages(), TRUE));
                }
            }
        }
        $viewModel = new ViewModel(['regForm' => $this->regForm,
                                    'message' => $message,
									//*** TRANSLATION LAB: set $useLocale = TRUE
                                    'useLocale' => TRUE]);
        return $viewModel;
    }
    public function setRegForm(RegForm $form)
    {
        $this->regForm = $form;
    }
	protected function logMessage($level, $message)
	{
		//*** LOGGER LAB: triggers an EVENT_SOMETHING event (recognized by the Logger\Listener)
		$this->getEventManager()
		     ->trigger( self::EVENT_SOMETHING, 
						$this, 
						['level' => Logger::INFO, 'message' => $message]
		);
	}
}
