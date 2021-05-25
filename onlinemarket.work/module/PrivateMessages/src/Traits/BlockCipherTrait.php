<?php
namespace PrivateMessages\Traits;

use Laminas\Crypt\BlockCipher;

trait BlockCipherTrait
{
    protected $blockCipher;
    public function setBlockCipher($blockCipher)
    {
        $this->blockCipher = $blockCipher;
    }
}
