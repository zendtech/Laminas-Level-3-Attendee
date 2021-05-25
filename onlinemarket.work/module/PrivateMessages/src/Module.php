<?php
namespace PrivateMessages;

use PrivateMessages\Hydrator\ {PrivateHydrator,BlockCipherHydrator,FormHydrator,TableHydrator};
use PrivateMessages\Model\Message;

use Laminas\Hydrator\ClassMethods;
use Laminas\Mvc\MvcEvent;
use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\Symmetric\Exception\NotFoundException;
use Laminas\Hydrator\Aggregate\AggregateHydrator;

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
            'factories' => [
				BlockCipherHydrator::class => function ($container) {
					$hydrator = new BlockCipherHydrator();
					$hydrator->setBlockCipher($container->get('encryption-block-cipher'));
					return $hydrator;
				},
                'private-messages-hydrator' => function ($container) {
					//*** BLOCK CIPHER LAB: create a hydrator which is an aggregate of classmethods + block cipher hydrators
					$hydroChain = new AggregateHydrator();
					$hydroChain->add(???);
					$hydroChain->add(???);
					return $hydroChain;
                },
            ],
        ];
    }
}
