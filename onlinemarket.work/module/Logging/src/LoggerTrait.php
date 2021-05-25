<?php
namespace Logging;

use Zend\Log\Logger;

trait LoggerTrait
{
    protected $logger;
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
}
