<?php
namespace Market\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;

class DeleteForm extends Form
{
	public function prepareElements()
	{
		$id = new Element\Hidden('id');
		
		$delCode = new Element\Text('delCode');
		$delCode->setLabel('Delete Code')
			 ->setAttribute('title', 'Enter code needed to delete this posting')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 128);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new Captcha\Dumb();
		$captchaAdapter->setWordlen(5);
		$captcha->setCaptcha($captchaAdapter)
			    ->setAttribute('title', 'Help to prevent SPAM');
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Delete')
			   ->setAttribute('title', 'Click here to delete this item');
		
		$cancel = new Element\Submit('cancel');
		$cancel->setAttribute('value', 'Cancel')
			   ->setAttribute('title', 'Click here to cancel deletion');
		
		$this->add($id)
			 ->add($delCode)
			 ->add($captcha)
			 ->add($submit)
			 ->add($cancel);
	}
} 
