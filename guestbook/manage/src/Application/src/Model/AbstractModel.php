<?php
namespace Application\Model;

abstract class AbstractModel
{
    const ERROR_HYDRATE = 'ERROR: unable to hydrate this object: need either an array or stdClass object';
    protected $mapping = [];
    protected $properties = [];
    public function __construct(array $properties = NULL)
    {
        if ($properties) $this->hydrate($properties);
    }
    public function __call($method, $value)
    {
        $prefix = substr($method, 0, 3);
        $key    = $this->normalizeKey(substr($method, 3));
        if ($prefix == 'get') {
            $result = $this->properties[$key] ?? NULL;
        } elseif ($prefix == 'set') {
            $this->properties[$key] = $value[0];
            $result = $this;
        } else {
            $result = NULL;
        }
        return $result;
    }
    public function unset($key)
    {
        if (isset($this->properties[$key])) {
            unset($this->properties[$key]);
        }
        return $this;
    }
    public function hydrate($input)
    {
        if (is_object($input)) {
            $props = get_object_vars($input);
            foreach ($props as $key => $value) {
                $this->properties[$this->normalizeKey($key)] = $value;
            }
        } elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                $this->properties[$this->normalizeKey($key)] = $value;
            }
        } else {
            throw new InvalidArgumentException(self::ERROR_HYDRATE);
        }
        return $this;
    }
    public function extract()
    {
        $data = [];
        foreach ($this->mapping as $key => $value) {
            $propKey = $this->normalizeKey($key);
            if (!empty($this->properties[$propKey])) {
                $data[$value] = $this->properties[$propKey];
            }
        }
        return $data;
    }
    protected function normalizeKey($key)
    {
        return str_replace('_', '', strtolower($key));
    }
}
