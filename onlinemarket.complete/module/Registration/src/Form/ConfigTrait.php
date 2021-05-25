<?php
namespace Registration\Form;

trait ConfigTrait
{
    protected $roleConfig;
    protected $providerConfig;
    protected $localeConfig;
    public function setRoleConfig(array $config)
    {
        $this->roleConfig = array_combine($config,$config);
    }
    public function setProviderConfig(array $config)
    {
        $this->providerConfig = array_combine($config,$config);
    }
    public function setLocaleConfig(array $config)
    {
        $this->localeConfig = array_combine($config,$config);
    }
}
