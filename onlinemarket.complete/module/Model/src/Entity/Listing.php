<?php
namespace Model\Entity;

/**
 * Class which represents entries in the "users" table
 *
CREATE TABLE `listings` (
  `listings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` char(16) NOT NULL,
  `title` varchar(128) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` timestamp NULL DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `photo_filename` varchar(1024) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(32) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `delete_code` char(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`listings_id`),
  KEY `title` (`title`),
  KEY `category` (`category`),
  KEY `delete_code` (`delete_code`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8
*/

class Listing
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    public $listings_id;
    public $category;
    public $title;
    public $date_created;
    public $date_expires;
    public $description;
    public $photo_filename;
    public $contact_name;
    public $contact_email;
    public $contact_phone;
    public $city;
    public $country;
    public $price;
    public $delete_code;
    public function __unset($key)
    {
        // don't get upset if we unset an unlisted property :-)
    }
}
