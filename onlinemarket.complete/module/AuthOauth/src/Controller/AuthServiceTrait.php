<?php
namespace AuthOauth\Controller;

use Laminas\Authentication\AuthenticationService;
trait AuthServiceTrait
{
    protected $authService;
    public function setAuthService(AuthenticationService $service)
    {
        $this->authService = $service;
    }
}
