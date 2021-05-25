<?php
namespace Application\Entity;

class User
{
    public $id;
    public $email;
    public $username;
    public $password;
    public $security_question;
    public $security_answer;
    public $role;
    public $provider;
    public $locale;
}
