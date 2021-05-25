<?php
namespace RestApi\Controller;

use RestApi\Service\ApiService;
use Laminas\View\Model\JsonModel;
use Laminas\Mvc\Controller\AbstractRestfulController;

class ApiController extends AbstractRestfulController
{
    protected $service;
    public function get($id)
    {
        return new JsonModel(['result' => $this->service->fetchById($id)]);
    }
    public function getList()
    {
        return new JsonModel(['result' => $this->service->fetchAll()]);
    }
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
