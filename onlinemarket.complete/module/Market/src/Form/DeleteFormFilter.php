<?php
namespace Market\Form;

use Laminas\InputFilter\Input;
use Laminas\Validator;
use Laminas\Filter;
use Laminas\InputFilter\InputFilter;

class DeleteFormFilter extends InputFilter
{
	public function prepareFilters()
	{
		$id = new Input('id');
		$id->getFilterChain()
		   ->attachByName('Int');
		
		$delCode = new Input('delCode');
		$delCode->getValidatorChain()
				->addByName('Alnum');
		
		$this->add($id)
			 ->add($delCode);
	}
} 
