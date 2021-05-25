<?php
namespace Guestbook\Form;

use Zend\Form\ {Form,Element};
use Zend\InputFilter\ {InputFilter, FileInput};
use Zend\Filter\File\RenameUpload;
use Zend\Validator\File\ {FilesSize, IsImage, ImageSize};
use Zend\Hydrator\ObjectProperty;
class Guestbook extends Form
{
    protected $config;
    public function __construct($name = __CLASS__, $options = [])
    {
        parent::__construct($name, $options);
        $this->setHydrator(new ObjectProperty());
    }
    public function setConfig($config)
    {
        $this->config = $config;
    }
    public function addElements()
    {
        // set form tag attribs
        $this->setAttributes(['method' => 'post', 'enctype' => 'multipart/form-data']);

        // assign elements
        $name = new Element\Text('name');
        $name->setLabel('Name');
        $this->add($name);
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $this->add($email);
        $website = new Element\Url('website');
        $website->setLabel('Website');
        $this->add($website);
        $message = new Element\Textarea('message');
        $message->setLabel('Comments');
        $message->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($message);
        $file = new Element\File('avatar');
        $file->setLabel('Avatar Image Upload');
        $this->add($file);
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Sign Guestbook',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
    public function addInputFilter()
    {
        $fileInput = new FileInput('avatar');
        $inputFilter = new InputFilter();

        // Define validators and filters as if only one file was being uploaded.
        $maxImgSize = new ImageSize($this->config['img_size']);
        $maxFileSize = new FilesSize($this->config['file_size']);
        $isImage = new IsImage();
        $fileInput->getValidatorChain()
                    ->attach($maxImgSize)
                    ->attach($maxFileSize)
                    ->attach($isImage);

        // All files will be renamed, e.g.: /../../../../data/uploads/xxx_4b3403665fea6.png,
        $fileInput->getFilterChain()->attach(new RenameUpload($this->config['rename']));
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}
