<?php
namespace Registration\Controller;

use Model\Entity\User;
use Model\Table\UsersTable;
use Model\Traits\UsersTableTrait;

use Registration\Form\RegForm;

use Laminas\Log\Logger;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

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
                $this->logMessage(Logger::WARN, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->regForm->getMessages(), TRUE));
            } else {
                $user = $this->regForm->getData();
                if ($this->table->save($user)) {
					$this->logMessage(Logger::INFO, __METHOD__ . ':' . self::REG_SUCCESS . ':' . $user->getEmail());
                    $this->flashMessenger()->addMessage(self::REG_SUCCESS);
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::REG_FAIL;
					$this->logMessage(Logger::ERROR, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->regForm->getMessages(), TRUE));
                }
            }
        }
        //*** TRANSLATION LAB: set $useLocale = TRUE
        $viewModel = new ViewModel(['regForm' => $this->regForm,
                                    'message' => $message,
                                    'useLocale' => FALSE]);
        return $viewModel;
    }
    public function setRegForm(RegForm $form)
    {
        $this->regForm = $form;
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
