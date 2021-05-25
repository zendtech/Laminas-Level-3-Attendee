<?php
namespace Application\Traits;
use Interop\Container\ContainerInterface;
trait ServiceContainerTrait
{
    protected $serviceContainer;
    public function setServiceContainer(ContainerInterface $container)
    {
        $this->serviceContainer = $container;
    }
}
