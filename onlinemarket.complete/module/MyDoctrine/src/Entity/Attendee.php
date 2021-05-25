<?php
namespace MyDoctrine\Entity;

//*** need "use" statement
use Doctrine\ORM\Mapping as ORM;

//*** need entity annotation
/**
 * @ORM\Entity("MyDoctrine\Entity\Attendee")
 * @ORM\Table("attendee_d")
 */
class Attendee
{
    //*** need annotations for each property
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    //*** configure a many to one relationship to to Registration
    /**
     * @ORM\ManyToOne(targetEntity="MyDoctrine\Entity\Registration", inversedBy="attendees")
     */
    protected $registration;

    /**
     * @ORM\Column(type="string", length=255, name="name_on_ticket")
     */
    protected $name;

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $registration
     */
    public function getRegistration() {
        return $this->registration;
    }

    /**
     * @return the $name_on_ticket
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $registration
     */
    public function setRegistration(Registration $registration) {
        $this->registration = $registration;
    }

    /**
     * @param field_type $name_on_ticket
     */
    public function setName($name_on_ticket) {
        $this->name = $name_on_ticket;
    }

}
