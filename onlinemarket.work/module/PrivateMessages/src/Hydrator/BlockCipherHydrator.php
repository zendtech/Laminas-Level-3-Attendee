<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\Message;
use Laminas\Crypt\BlockCipher;
use Laminas\Hydrator\HydratorInterface;

class BlockCipherHydrator implements HydratorInterface
{
    protected $blockCipher;
    public function setBlockCipher(BlockCipher $blockCipher)
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
        return $data;
    }
}
