<?php
namespace Logging;

use Laminas\Log\Logger;

trait LoggerTrait
{
    protected $logger;
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
}
