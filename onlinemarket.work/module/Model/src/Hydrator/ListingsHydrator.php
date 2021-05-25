<?php
//*** AGGREGATE HYDRATOR LAB: this needs to be defined
namespace Model\Hydrator;

use DateTime;
use DateInterval;
use Model\Entity\Listing;
use Laminas\Hydrator\HydratorInterface;

class ListingsHydrator implements HydratorInterface
{
    public function hydrate(array $data, $listing)
    {
        if ($listing instanceof Listing) {
            //*** AGGREGATE HYDRATOR LAB: move logic from ListingsTable::save() here
            //*** AGGREGATE HYDRATOR LAB: calculate expires date
            //*** AGGREGATE HYDRATOR LAB: break out city and country from cityCode
            //*** AGGREGATE HYDRATOR LAB: unset unwanted fields
        }
        return $listing;
    }

    public function extract($listing)
    {
        $data = [];
        if ($listing instanceof Listing) {
            //*** AGGREGATE HYDRATOR LAB: convert `date_created` and `date_expires` columns into DateTime instance
        }
        return $data;
    }
}

// result of form posting:
/*
Market\Controller\PostController::indexAction object(Model\Entity\Listing)#1762 (19) {
  ["listings_id"] => NULL
  ["category"] => string(4) "free"
  ["title"] => string(11) "Pom Puppies"
  ["date_created"] => NULL
  ["date_expires"] => NULL
  ["description"] => string(29) "8 Furballs for free.  HELP!!!"
  ["photo_filename"] => array(5) {
    ["name"] => string(25) "suchi_milo_front_step.png"
    ["type"] => string(9) "image/png"
    ["tmp_name"] => string(129) "/home/fred/Desktop/Repos/ZF-Level-3/Course_Applications/onlinemarket.complete/public/images/phpzLttfU_5b064197e2dd32_76518590.png"
    ["error"] => int(0)
    ["size"] => int(763056)
  }
  ["contact_name"] => string(16) "Lots A. Furballs"
  ["contact_email"] => string(21) "too@many.furballs.com"
  ["contact_phone"] => string(12) "111-111-1111"
  ["city"] => NULL
  ["country"] => NULL
  ["price"] => string(5) "99.99"
  ["delete_code"] => string(5) "12345"
  ["expires"] => string(1) "7"
  ["cityCode"] => string(8) "Surin,TH"
  ["captcha"] => array(2) {
    ["id"] => string(32) "231693cce4ea3e064e47e734077c95a4"
    ["input"] => string(4) "z52a"
  }
  ["submit"] => string(4) "Post"
  ["csrf"] => string(65) "0224f507bb2d4f661d02d530c09c7f43-b830c36cbd8aafbda03b3a0a39ab3fa9"
}
*/
