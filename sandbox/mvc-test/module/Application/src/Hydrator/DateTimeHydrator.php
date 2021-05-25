<?php
namespace Application\Hydrator;

use DateTime;
use Application\Entity\Message;
use Zend\Hydrator\HydratorInterface;

class DateTimeHydrator implements HydratorInterface
{
    public function hydrate(array $data, $object)
    {
        if ($object instanceof Message) {
            if (isset($data['date_time']) && is_string($data['date_time'])) {
                $object->date_time = new DateTime($data['date_time']);
            }
        }
        return $object;
    }

    public function extract($object)
    {
        $data = [];
        if ($object instanceof Message) {
            if (isset($object->date_time) && ($object->date_time instanceof DateTime)) {
                $data['date_time'] = $object->date_time->format(Message::DATE_FORMAT_OUT);
            }
        }
        return $data;
    }
}
