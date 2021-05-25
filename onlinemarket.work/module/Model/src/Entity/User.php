<?php
namespace Model\Entity;

/**
 * Class which represents entries in the "users" table
 *
CREATE TABLE `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(254) DEFAULT NULL,
  `security_question` varchar(254) DEFAULT NULL,
  `security_answer` varchar(254) DEFAULT NULL,
  `role` char(8) DEFAULT 'user',
  `provider` char(8) DEFAULT 'default',
  `locale` char(8) DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1
*/

class User
{
    protected $id;
    protected $email;
    protected $username;
    protected $password;
    protected $securityQuestion;
    protected $securityAnswer;
    protected $provider;
    protected $locale;
    protected $role;

    public function __construct(array $data = [])
    {
        foreach ($data as $name => $value) {
            if (property_exists(__CLASS__, $name)) {
                $this->$name = $value;
            }
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($val)
    {
        $this->id = $val;
        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($val)
    {
        $this->email = $val;
        return $this;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($val)
    {
        $this->username = $val;
        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($val)
    {
        $this->password = $val;
        return $this;
    }
    public function getSecurityQuestion()
    {
        return $this->securityQuestion;
    }
    public function setSecurityQuestion($val)
    {
        $this->securityQuestion = $val;
        return $this;
    }
    public function getSecurityAnswer()
    {
        return $this->securityAnswer;
    }
    public function setSecurityAnswer($val)
    {
        $this->securityAnswer = $val;
        return $this;
    }
    public function getProvider()
    {
        return $this->provider;
    }
    public function setProvider($val)
    {
        $this->provider = $val;
        return $this;
    }
    public function getLocale()
    {
        return $this->locale;
    }
    public function setLocale($val)
    {
        $this->locale = $val;
        return $this;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($val)
    {
        $this->role = $val;
        return $this;
    }
}
