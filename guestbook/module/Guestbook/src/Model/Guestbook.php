<?php
namespace Guestbook\Model;

class Guestbook
{

    const TABLE_NAME      = 'guestbook';
    const DATE_FORMAT_IN  = 'Y-m-d H:i:s';
    const DATE_FORMAT_OUT = 'l,d M Y H:i:s';

    public $id;
    public $name;
    public $email;
    public $website;
    public $message;
    public $avatar;
    public $dateSigned;

    public function __construct($data = array())
    {
        if ($data) {
            $existing = get_object_vars($this);
            foreach ($existing as $key => $value) {
                $this->$key = $data[$key] ?? $value ?? NULL;
            }
        }
    }

    public function unset($key)
    {
        if (isset(get_object_vars($this)[$key])) {
            unset($this->$key);
        }
        return $this;
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
        return $this;
    }
}
