<?php
//*** REST LAB
namespace RestApi\Controller;

use RestApi\Service\ApiService;
use Laminas\View\Model\JsonModel;
use Laminas\Mvc\Controller\AbstractRestfulController;

class ApiController extends AbstractRestfulController
{
    protected $service;
    //*** define methods for an HTTP GET with and without an ID
    public function get($id)
    {
        //*** define this method
        return new JsonModel(['result' => $this->service->fetchById($id)]);
    }
    public function getList()
    {
        //*** define this method
        return new JsonModel(['result' => $this->service->fetchAll()]);
    }
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
