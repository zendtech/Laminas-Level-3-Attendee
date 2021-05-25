<?php
namespace Translation\Listener;

use Locale;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {AbstractListenerAggregate,EventManagerInterface};
use Interop\Container\ContainerInterface;
use Login\Event\LoginEvent;

class TranslationListenerAggregate extends AbstractListenerAggregate
{
    protected $container;   // service manager container
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        //*** make the appropriate attachments here
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,    [$this, 'setTranslatorLocaleFromAuth'], 99);
        $this->listeners[] = $shared->attach('*', Event::EVENT_LOCALE_USER,    [$this, 'setTranslatorLocaleFromAuth']);
        $this->listeners[] = $shared->attach('*', Event::EVENT_LOCALE_PARAM,   [$this, 'setTranslatorLocaleFromParam']);
        $this->listeners[] = $shared->attach('*', LoginEvent::EVENT_LOGIN_VIEW,[$this, 'injectLinks'], 99);
    }
    //*** define a listener which sets locale based on an Event parameter
    public function setTranslatorLocaleFromParam($e)
    {
        $locale = $e->getParam('locale') ?? Locale::getDefault();
        $this->setTranslatorLocale($locale);
    }
    //*** define a listener which sets locale based on a user identity property "locale"
    public function setTranslatorLocaleFromAuth($e)
    {
        $locale = Locale::getDefault();
        $authService = $this->container->get('login-auth-service');
        if ($authService && $authService->hasIdentity()) {
            $user = $authService->getIdentity();
            $locale = $user->getLocale() ?? Locale::getDefault();
        }
        $this->setTranslatorLocale($locale);
    }
    //*** define a listener which sets a variable "localeLink" on the view model obtained as a parameter "viewModel"
    public function injectLinks($e)
    {
        $viewModel = $e->getParam('viewModel');
        $viewModel->setVariable('localeLink', 1);
    }
    protected function setTranslatorLocale($locale)
    {
        $translator = $this->container->get('MvcTranslator');
        $translator->setLocale($locale);
        Locale::setDefault($locale);
    }
}
