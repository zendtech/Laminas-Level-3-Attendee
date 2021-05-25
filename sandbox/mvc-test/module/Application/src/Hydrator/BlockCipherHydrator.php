<?php
namespace Application\Hydrator;

use Application\Entity\Message;
use Zend\Crypt\BlockCipher;
use Zend\Hydrator\HydratorInterface;

class BlockCipherHydrator implements HydratorInterface
{

    protected $blockCipher;

    public function __construct($key, $algo)
    {
        // set up block cipher
        $config = explode('-', $algo);
        $this->blockCipher = BlockCipher::factory('openssl', ['algo' => $config[0], 'mode' => $config[2]]);
        $this->blockCipher->setKey($key);
    }
    public function hydrate(array $data, $object)
    {
        if ($object instanceof Message) {
            if (isset($data['message'])) {
                $object->message = $this->blockCipher->decrypt($object->message);
            }
        }
        return $object;
    }

    public function extract($object)
    {
        $data = [];
        if ($object instanceof Message) {
            if (isset($object->message)) {
                $data['message'] = $this->blockCipher->encrypt($object->message);
            }
        }
        return $data;
    }
}
