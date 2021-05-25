<?php

namespace LoggerProxy\__PM__\Logging\Logger\Logging;

class Generated4bbf607093d7c1d3a93253f71d7a3222 extends \Logging\Logger\Logging implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHoldera1a5c = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer010be = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties74ee0 = [
        
    ];

    private static $signature4bbf607093d7c1d3a93253f71d7a3222 = 'YTo0OntzOjk6ImNsYXNzTmFtZSI7czoyMjoiTG9nZ2luZ1xMb2dnZXJcTG9nZ2luZyI7czo3OiJmYWN0b3J5IjtzOjUwOiJQcm94eU1hbmFnZXJcRmFjdG9yeVxMYXp5TG9hZGluZ1ZhbHVlSG9sZGVyRmFjdG9yeSI7czoxOToicHJveHlNYW5hZ2VyVmVyc2lvbiI7czo0NjoiMi4yLjNANGQxNTQ3NDJlMzFjMzUxMzdkNTM3NGM5OThlOGY4NmI1NGRiMmUyZiI7czoxMjoicHJveHlPcHRpb25zIjthOjA6e319';

    public function __destruct()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__destruct', array(), $this->initializer010be);

        return $this->valueHoldera1a5c->__destruct();
    }

    public function getWriterPluginManager()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'getWriterPluginManager', array(), $this->initializer010be);

        return $this->valueHoldera1a5c->getWriterPluginManager();
    }

    public function setWriterPluginManager(\Zend\Log\WriterPluginManager $writerPlugins)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'setWriterPluginManager', array('writerPlugins' => $writerPlugins), $this->initializer010be);

        return $this->valueHoldera1a5c->setWriterPluginManager($writerPlugins);
    }

    public function writerPlugin($name, ?array $options = null)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'writerPlugin', array('name' => $name, 'options' => $options), $this->initializer010be);

        return $this->valueHoldera1a5c->writerPlugin($name, $options);
    }

    public function addWriter($writer, $priority = 1, ?array $options = null)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'addWriter', array('writer' => $writer, 'priority' => $priority, 'options' => $options), $this->initializer010be);

        return $this->valueHoldera1a5c->addWriter($writer, $priority, $options);
    }

    public function getWriters()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'getWriters', array(), $this->initializer010be);

        return $this->valueHoldera1a5c->getWriters();
    }

    public function setWriters(\Zend\Stdlib\SplPriorityQueue $writers)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'setWriters', array('writers' => $writers), $this->initializer010be);

        return $this->valueHoldera1a5c->setWriters($writers);
    }

    public function getProcessorPluginManager()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'getProcessorPluginManager', array(), $this->initializer010be);

        return $this->valueHoldera1a5c->getProcessorPluginManager();
    }

    public function setProcessorPluginManager($plugins)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'setProcessorPluginManager', array('plugins' => $plugins), $this->initializer010be);

        return $this->valueHoldera1a5c->setProcessorPluginManager($plugins);
    }

    public function processorPlugin($name, ?array $options = null)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'processorPlugin', array('name' => $name, 'options' => $options), $this->initializer010be);

        return $this->valueHoldera1a5c->processorPlugin($name, $options);
    }

    public function addProcessor($processor, $priority = 1, ?array $options = null)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'addProcessor', array('processor' => $processor, 'priority' => $priority, 'options' => $options), $this->initializer010be);

        return $this->valueHoldera1a5c->addProcessor($processor, $priority, $options);
    }

    public function getProcessors()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'getProcessors', array(), $this->initializer010be);

        return $this->valueHoldera1a5c->getProcessors();
    }

    public function log($priority, $message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'log', array('priority' => $priority, 'message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->log($priority, $message, $extra);
    }

    public function emerg($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'emerg', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->emerg($message, $extra);
    }

    public function alert($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'alert', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->alert($message, $extra);
    }

    public function crit($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'crit', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->crit($message, $extra);
    }

    public function err($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'err', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->err($message, $extra);
    }

    public function warn($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'warn', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->warn($message, $extra);
    }

    public function notice($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'notice', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->notice($message, $extra);
    }

    public function info($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'info', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->info($message, $extra);
    }

    public function debug($message, $extra = [])
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'debug', array('message' => $message, 'extra' => $extra), $this->initializer010be);

        return $this->valueHoldera1a5c->debug($message, $extra);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? $reflection = new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        unset($instance->priorities, $instance->writers, $instance->processors, $instance->writerPlugins, $instance->processorPlugins);

        $instance->initializer010be = $initializer;

        return $instance;
    }

    public function __construct($options = null)
    {
        static $reflection;

        if (! $this->valueHoldera1a5c) {
            $reflection = $reflection ?: new \ReflectionClass('Logging\\Logger\\Logging');
            $this->valueHoldera1a5c = $reflection->newInstanceWithoutConstructor();
        unset($this->priorities, $this->writers, $this->processors, $this->writerPlugins, $this->processorPlugins);

        }

        $this->valueHoldera1a5c->__construct($options);
    }

    public function & __get($name)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__get', ['name' => $name], $this->initializer010be);

        if (isset(self::$publicProperties74ee0[$name])) {
            return $this->valueHoldera1a5c->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera1a5c;

            $backtrace = debug_backtrace(false);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    get_parent_class($this),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
            return;
        }

        $targetObject = $this->valueHoldera1a5c;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer010be);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera1a5c;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHoldera1a5c;
        $accessor = function & () use ($targetObject, $name, $value) {
            return $targetObject->$name = $value;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__isset', array('name' => $name), $this->initializer010be);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera1a5c;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHoldera1a5c;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__unset', array('name' => $name), $this->initializer010be);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera1a5c;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHoldera1a5c;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __clone()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__clone', array(), $this->initializer010be);

        $this->valueHoldera1a5c = clone $this->valueHoldera1a5c;
    }

    public function __sleep()
    {
        $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, '__sleep', array(), $this->initializer010be);

        return array('valueHoldera1a5c');
    }

    public function __wakeup()
    {
        unset($this->priorities, $this->writers, $this->processors, $this->writerPlugins, $this->processorPlugins);
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer010be = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer010be;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer010be && $this->initializer010be->__invoke($this->valueHoldera1a5c, $this, 'initializeProxy', array(), $this->initializer010be);
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldera1a5c;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldera1a5c;
    }


}
