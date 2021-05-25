<?php
namespace Encryption;

use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\Exception\ {NotFoundException, RuntimeException};

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';

    public function getServiceConfig()
    {
        return [
            //*** BLOCK CIPHER LAB: you need to first check to make sure preferred openssl algos exist
            //***                   by running "openssl_get_cipher_methods()"
            'services' => [
                'encryption-algo' => ???,       // choose your preferred algorithm
                'encryption-mode' => ???,       // choose your preferred mode
                'encryption-key'  => ???,       // generate a key which fits the algorithm and mode
            ],
            'factories' => [
                //*** BLOCK CIPHER LAB: return a block cipher instance
                'encryption-block-cipher' => function ($container) {
					$config = ['algo' => $container->get('encryption-algo'),
                               'mode' => $container->get('encryption-mode') ];
                    //*** BLOCK CIPHER LAB: generate a block cipher based on "openssl"
                    $cipher = ???
                    //*** BLOCK CIPHER LAB: set the key
                    $cipher->setKey(???);
                    return $cipher;
                },
            ],
        ];
    }
}
