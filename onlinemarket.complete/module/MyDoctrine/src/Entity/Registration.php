<?php
namespace MyDoctrine\Entity;

//*** need "use" statements
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyDoctrine\Entity\Attendee;

//*** need entity annotation
/**
 * @ORM\Entity("MyDoctrine\Entity\Registration")
 * @ORM\Table("registration_d")
 */
class Registration
{
    //*** need annotations for each property
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, name="first_name")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, name="last_name")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="datetime", name="registration_time")
     */
    protected $registrationTime;

    //*** configure a one to many relationship to Attendee
    /**
     * @ORM\OneToMany(targetEntity="MyDoctrine\Entity\Attendee", mappedBy="registration")
     */
    protected $attendees = array();

    //*** configure a many to one relationship to to Event
    /**
     * @ORM\ManyToOne(targetEntity="MyDoctrine\Entity\Event", inversedBy="registrations")
     */
    protected $event;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $firstName
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return the $lastName
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return the $registrationTime
     */
    public function getRegistrationTime() {
        return $this->registrationTime->format('l, d M Y');
    }

    /**
     * @return the $attendees
     */
    public function getAttendees() {
        return $this->attendees;
    }

    /**
     * @return the back-linked Event entity
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @param field_type $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @param field_type $registrationTime
     */
    public function setRegistrationTime($registrationTime = NULL) {
        if ($registrationTime == NULL) {
            $registrationTime = new \DateTime('now');
        }
        $this->registrationTime = $registrationTime;
    }

    //*** needs annotation
    /**
     * @param multitype: $attendees
     */
    public function setAttendees(Attendee $attendee) {
        //*** what goes here?
        $this->attendees[] = $attendee;
    }

    /**
     * @param int $event
     */
    public function setEvent($event) {
        $this->event = $event;
    }


}
