<?php
namespace Login\Traits;

use Zend\Authentication\AuthenticationService;

trait AuthServiceTrait
{
    protected $authService;
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
    }
}
