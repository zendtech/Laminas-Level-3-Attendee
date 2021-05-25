<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\Message;
use Zend\Hydrator\HydratorInterface;

class BlockCipherHydrator implements HydratorInterface
{
    protected $blockCipher;
    public function setBlockCipher($blockCipher)
    {
		$this->blockCipher = $blockCipher;
	}
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        //*** BLOCK CIPHER LAB: use the block cipher to decrypt the message
		if (isset($data['message'])) {
			$object->setMessage(???);
		}
        return $object;
    }
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        //*** BLOCK CIPHER LAB: use the block cipher to encrypt the message
        $data = [];
		if ($object->getMessage()) {
			$data['message'] = ???;
		}
        return $data;
    }
}
