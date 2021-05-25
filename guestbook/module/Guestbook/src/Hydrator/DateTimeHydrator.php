<?php
namespace Guestbook\Hydrator;

use DateTime;
use Guestbook\Model\Guestbook
use Zend\Hydrator\HydratorInterface;

class DateTimeHydrator implements HydratorInterface
{
    public function hydrate(array $data, $object)
    {
        if ($object instanceof Guestbook) {
            if (isset($data['dateSigned']) && is_string($data['dateSigned'])) {
                $object->dateSigned = new DateTime($data['dateSigned']);
            }
        }
        return $object;
    }

    public function extract($object)
    {
        $data = [];
        if ($object instanceof Guestbook) {
            if (isset($object->dateSigned) && ($object->dateSigned instanceof DateTime)) {
                $data['dateSigned'] = $object->dateSigned->format(Message::DATE_FORMAT_OUT);
            }
        }
        return $data;
    }
}
