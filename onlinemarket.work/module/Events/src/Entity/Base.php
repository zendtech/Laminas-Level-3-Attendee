<?php
namespace Events\Entity;

use DateTime;
class Base implements EventEntityInterface
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    public $id;
    public function __construct($data = NULL)
    {
        if (!empty($data)) {
            $props = get_object_vars($this);
            foreach ($props as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($data[$key] ?? NULL);
                } else {
                    $this->$key = $data[$key] ?? NULL;
                }
            }
        }
    }
}
