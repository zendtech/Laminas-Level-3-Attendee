<?php
namespace Market\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Captcha\Image as ImageCaptcha;

class PostForm extends Form
{
    use CategoryTrait;
    use ExpireDaysTrait;

    protected $captchaOptions;

    public function buildForm()
    {
        $this->setAttribute('method', 'post');

        //*** FILE UPLOAD LAB: modify form attributes for file upload
        $this->setAttribute('enctype', 'multipart/form-data');

        $category = new Element\Select('category');
        $category->setLabel('Category')
            ->setAttribute('title', 'Please select a category')
            ->setValueOptions(array_combine($this->getCategories(), $this->getCategories()))
            ->setLabelAttributes(['style' => 'display: block']);

        $title = new Element\Text('title');
        $title->setLabel('Title')
            ->setAttribute('placeholder', 'Enter posting title')
            ->setLabelAttributes(['style'=>'display:block']);

        //*** FILE UPLOAD LAB: convert this to a file upload form element
        $photo = new Element\File('photo_filename');
        $photo->setLabel('Photo')
            ->setAttribute('placeholder', 'Upload image')
            ->setLabelAttributes(['style'=>'display:block']);

        $price = new Element\Text('price');
        $price->setLabel('Price')
            ->setAttribute('title', 'Enter price as nnn.nn')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16)
            ->setAttribute('placeholder', 'Enter a value')
            ->setLabelAttributes(['style'=>'display:block']);

        $expires = new Element\Radio('expires');
        $expires->setLabel('Expires')
            ->setAttribute('title', 'The expiration date will be calculated from today')
            ->setAttribute('class', 'expiresButton')
            ->setValueOptions($this->getExpireDays());

        $city = new Element\Text('cityCode');
        $city->setLabel('Nearest City,Country')
            ->setAttribute('title', 'Enter as "city,country" using 2 letter ISO code for country')
            ->setAttribute('id', 'cityCode')
            ->setAttribute('placeholder', 'City Name,CC')
            ->setLabelAttributes(['style'=>'display:inline']);

        $name = new Element\Text('contact_name');
        $name->setLabel('Contact Name')
            ->setAttribute('title', 'Enter the name of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $phone = new Element\Text('contact_phone');
        $phone->setLabel('Contact Phone Number')
            ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
            ->setAttribute('size', 20)
            ->setAttribute('maxlength', 32)
            ->setLabelAttributes(['style'=>'display:block']);

        $email = new Element\Email('contact_email');
        $email->setLabel('Contact Email')
            ->setAttribute('title', 'Enter the email address of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $description = new Element\Textarea('description');
        $description->setLabel('Description')
            ->setAttribute('title', 'Enter a suitable description for this posting')
            ->setAttribute('rows', 4)
            ->setAttribute('cols', 80);

        $delCode = new Element\Text('delete_code');
        $delCode->setLabel('Delete Code')
            ->setAttribute('title', 'Enter the delete code for this item')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16);

        $captcha = new Element\Captcha('captcha');
        $captchaAdapter = new ImageCaptcha();
        $captchaAdapter->setWordlen(4)
            ->setOptions($this->getCaptchaOptions());
        $captcha->setCaptcha($captchaAdapter)
            ->setLabel('Help us to prevent SPAM!')
            ->setAttribute('title', 'Help to prevent SPAM');

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Post')
               ->setAttribute('style', 'font-size: 16pt; font-weight:bold;')
               ->setAttribute('class', 'btn btn-success white');

        $this->add($category)
            ->add($title)
            ->add($photo)
            ->add($price)
            ->add($expires)
            ->add($city)
            ->add($name)
            ->add($phone)
            ->add($email)
            ->add($description)
            ->add($delCode)
            ->add($captcha)
            ->add($submit);
    }

    /**
     * @return the $captchaOptions
     */
    public function getCaptchaOptions() {
        return $this->captchaOptions;
    }

    /**
     * @param field_type $captchaOptions
     */
    public function setCaptchaOptions($captchaOptions) {
        $this->captchaOptions = $captchaOptions;
    }

}
