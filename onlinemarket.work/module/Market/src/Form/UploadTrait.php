<?php
namespace Market\Form;

trait UploadTrait
{
    protected $uploadConfig;
    /**
     * @return the $uploadConfig
     */
    public function getUploadConfig() {
        return $this->uploadConfig;
    }

    /**
     * @param field_type $uploadConfig
     */
    public function setUploadConfig($uploadConfig) {
        $this->uploadConfig = $uploadConfig;
    }

}
