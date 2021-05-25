<?php
//*** SECURITY: BLOCK CIPHER LAB
namespace Encryption;

use Zend\Crypt\BlockCipher;
use Zend\Crypt\Exception\ {NotFoundException, RuntimeException};

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';

    public function getServiceConfig()
    {
        return [
            'services' => [
                'encryption-key' => 'AXee4aivHieQuei8Ophao8Ooda7AhbiX',
                'encryption-algos' => ['aes-256-ctr'],
            ],
            'factories' => [
                //*** return a block cipher instance
                'encryption-block-cipher' => function ($container) {
                    $cipher = BlockCipher::factory('openssl', $container->get('encryption-get-config-array'));
                    $cipher->setKey($container->get('encryption-key'));
                    return $cipher;
                },
                //*** checks to make sure preferred openssl algos exist
                //*** returns an array with params required to create BlockCipher instance
                'encryption-get-config-array' => function ($container) {
                    if (!function_exists('openssl_get_cipher_methods')) {
                        throw new RuntimeException(self::ERROR_OPENSSL);
                    }
                    // get list of preferred algos
                    $preferred = $container->get('encryption-algos');
                    // get list of algos supported on this server
                    $supported = openssl_get_cipher_methods();
                    $chosen = FALSE;
                    // go with the 1st algo on the supported list
                    foreach ($preferred as $key => $algo) {
                        if (in_array($algo, $supported)) {
                            $chosen = $key;
                            break;
                        }
                    }
                    if ($chosen === FALSE) {
                        throw new NotFoundException(self::ERROR_ALGO);
                    }
                    $config = [];
                    $breakdown = explode('-', $preferred[$key]);
                    $config = [
                        'algo' => $breakdown[0],
                        'mode' => $breakdown[2]
                    ];
                    return $config;
                },
            ],
        ];
    }
}
