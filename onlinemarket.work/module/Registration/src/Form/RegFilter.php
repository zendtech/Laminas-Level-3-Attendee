<?php
namespace Registration\Form;

use Laminas\Filter;
use Laminas\Validator;
use Laminas\I18n\Validator\ {Alnum,Alpha};
use Laminas\InputFilter\ {InputFilter, Input};

class RegFilter extends InputFilter
{
    use ConfigTrait;

    public function __construct($roles, $providers, $locales)
    {
        $this->setRoleConfig($roles);
        $this->setProviderConfig($providers);
        $this->setLocaleConfig($locales);
        $this->addInputFilter();
    }

    public function addInputFilter()
    {
        $email = new Input('email');
        $email->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $email->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $this->add($email);

        $password = new Input('password');
        $password->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $this->add($password);

        $username = new Input('username');
        $username->getValidatorChain()
              ->attach(new Validator\NotEmpty())
              ->attach(new Alnum());
        $username->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $this->add($username);

        $question = new Input('securityQuestion');
        $question->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $question->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $this->add($question);

        $answer = new Input('securityAnswer');
        $answer->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $answer->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $this->add($answer);

        $role = new Input('role');
        $role->setRequired(TRUE);
        $role->getValidatorChain()
                ->attachByName('InArray', array('haystack' => $this->roleConfig));
        $role->getFilterChain()
                ->attach(new Alpha());
        $this->add($role);

        $provider = new Input('provider');
        $provider->setRequired(TRUE);
        $provider->getValidatorChain()
                ->attachByName('InArray', array('haystack' => $this->providerConfig));
        $provider->getFilterChain()
                ->attach(new Alpha());
        $this->add($provider);

        //*** I18N LAB: uncomment this filter
        /*
        $locale = new Input('locale');
        $locale->setRequired(FALSE);
        $locale->getValidatorChain()
                ->attachByName('InArray', array('haystack' => $this->localeConfig));
        $locale->getFilterChain()
                ->attach(new Alpha());
        $this->add($locale);
        */
    }
}
