<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\Message;
use Laminas\Hydrator\HydratorInterface;

class FormHydrator implements HydratorInterface
{
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data == $_POST from form
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $mapping = $object->getMapping();
        foreach ($mapping as $formField => $colName) {
            if (isset($data[$formField])) {
                $method = 'set' . $formField;
                $object->$method($data[$formField]);
            }
        }
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
        $data = [];
        $mapping = $object->getMapping();
        foreach ($mapping as $formField => $colName) {
            $method = 'get' . $formField;
            $data[$formField] = $object->$method();
        }
        return $data;
    }
}
