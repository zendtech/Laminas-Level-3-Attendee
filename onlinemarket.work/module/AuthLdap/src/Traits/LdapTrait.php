<?php
namespace AuthLdap\Traits;

trait LdapTrait
{
    protected $ldapAdapter;
    public function setLdapAdapter($adapter)
    {
        $this->ldapAdapter = $adapter;
    }
}
