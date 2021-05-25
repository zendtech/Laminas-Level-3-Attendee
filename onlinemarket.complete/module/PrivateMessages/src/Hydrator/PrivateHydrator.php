<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\Message;
use PrivateMessages\Traits\BlockCipherTrait;
use Zend\Hydrator\HydratorInterface;

class PrivateHydrator implements HydratorInterface
{
    use BlockCipherTrait;
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        //*** use the block cipher to decrypt the message
        if (isset($data['message']) && !empty($data['message'])) {
            try {
                $data['message'] = $this->blockCipher->decrypt($data['message']);
            } catch (Exception $e) {
                error_log(__METHOD__ . ':' . $e->getMessage());
                $data['message'] = '';
            }
        } else {
            $data['message'] = '';
        }
        return new Message($data);
    }
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        //*** use the block cipher to encrypt the message
        $data = $object->extract();
        if (isset($data['message'])) {
            $data['message'] = $this->blockCipher->encrypt($data['message']);
        } else {
            $data['message'] = '';
        }
        return $data;
    }
}
