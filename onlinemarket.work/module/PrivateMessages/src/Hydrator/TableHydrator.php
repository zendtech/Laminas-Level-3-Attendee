<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\Message;
use Zend\Hydrator\HydratorInterface;

class TableHydrator implements HydratorInterface
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
			if (isset($data[$colName])) {
				$method = 'set' . $colName;
				$object->$method($data[$colName]);
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
			$method = 'get' . $colName;
			$data[$colName] = $object->$method();
		}
        return $data;
    }
}
