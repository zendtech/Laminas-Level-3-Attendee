<?php
namespace PrivateMessages;

use PrivateMessages\Hydrator\PrivateHydrator;
use PrivateMessages\Model\Message;

use Zend\Mvc\MvcEvent;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Exception\NotFoundException;
use Zend\Crypt\PublicKey\DiffieHellman;

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';

    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
                'private-messages-key' => 'AXee4aivHieQuei8Ophao8Ooda7AhbiX',
                'private-messages-algo' => 'aes-256-ctr',
            ],
            'factories' => [
                'private-messages-block-cipher' =>
                    function ($container) {
                        $config = explode('-',$container->get('private-messages-algo'));
                        $cipher = BlockCipher::factory(
                            'openssl', ['algo' => $config[0], 'mode' => $config[2]]);
                        $cipher->setKey($container->get('private-messages-key'));
                        return $cipher;
                },
                'private-messages-hydrator' =>
                    function ($container) {
                        $hydrator = new PrivateHydrator();
                        $hydrator->setBlockCipher($container->get('private-messages-block-cipher'));
                        return $hydrator;
                },
            ],
        ];
    }
}
