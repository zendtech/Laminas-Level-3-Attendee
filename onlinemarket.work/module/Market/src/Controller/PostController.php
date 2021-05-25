<?php
namespace Market\Controller;

use Market\Form\UploadTrait;
use Market\Event\LogEvent;
use Market\Listener\CacheAggregate;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Notification\Event\NotificationEvent;

class PostController extends AbstractActionController implements ListingsTableAwareInterface
{

    const ERROR_POST = 'ERROR: unable to validate item information';
    const ERROR_SAVE = 'ERROR: unable to save item to the database';
    const SUCCESS_POST = 'SUCCESS: item posted OK';

    use PostFormTrait;
    use ListingsTableTrait;
    use CityCodesTableTrait;
    use UploadTrait;

    public function indexAction()
    {

        $data = [];

        if ($this->getRequest()->isPost()) {

            // combine $_POST with $_FILES
            $data = array_merge($this->params()->fromPost(), $this->params()->fromFiles());
            $this->postForm->setData($data);

            if ($this->postForm->isValid()) {

                // retrieve data: due to form binding will get a Model\Entity\Listing instance
                $listing = $this->postForm->getData();

                // move uploaded file from /images folder into /images/<category>
                $tmpFn     = $listing->photo_filename['tmp_name'];
                $tmpDir    = dirname($tmpFn);
                $partialFn = '/' . $listing->category . '/' . basename($tmpFn);
                $finalFn   = str_replace('//', '/', $tmpDir . $partialFn);
                rename($tmpFn, $finalFn);

                // reset $listing->photo_filename'] to final filename /images/<category>/filename
                $listing->photo_filename = $this->uploadConfig['img_url'] . $partialFn;

                // save data and process
                if ($this->listingsTable->save($listing)) {

                    $this->flashMessenger()->addMessage(self::SUCCESS_POST);
                    $this->getEventManager()->trigger('notification-event-email-notification', $this, ['message' => 'Successfully posted ' . $listing->title]);
                    $em = $this->getEventManager();
                    $em->addIdentifiers([LogEvent::LOG_ID]);
                    $em->trigger(LogEvent::LOG_EVENT, $this, ['title' => $listing->title]);
                    $cacheKey = 'market_view_category_' . $listing->category;
                    $em->trigger(CacheAggregate::EVENT_CLEAR_CACHE, $this, ['cacheKey' => $cacheKey]);
                    return $this->redirect()->toRoute('market');

                } else {

                    $this->flashMessenger()->addMessage(self::ERROR_SAVE);

                }

            } else {

                $this->flashMessenger()->addMessage(self::ERROR_POST);

            }
        }

        $viewModel = new ViewModel(['postForm' => $this->postForm, 'data' => $data, 'flash' => $this->flashMessenger()]);
        $viewModel->setTemplate('market/post/index');
        return $viewModel;

    }

}
