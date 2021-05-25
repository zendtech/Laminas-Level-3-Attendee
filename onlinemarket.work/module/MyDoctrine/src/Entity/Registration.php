<?php
namespace MyDoctrine\Entity;

//*** DOCTRINE LAB: need Doctrine "use" statements
use MyDoctrine\Entity\Attendee;

//*** DOCTRINE LAB: need class entity annotations
/**
 * @ORM\???
 */
class Registration
{
    //*** DOCTRINE LAB: how do you tell Doctrine this is the indentifying property?
    /**
     * @ORM\Column(???)
     */
    protected $id;

    //*** DOCTRINE LAB: need annotations for each property
    /**
     * @ORM\Column(???)
     */
    protected $firstName;

    /**
     * @ORM\Column(???)
     */
    protected $lastName;

    /**
     * @ORM\Column(???)
     */
    protected $registrationTime;

    //*** DOCTRINE LAB: configure a one to many relationship to Attendee
    /**
     * @ORM\OneToMany(???)
     */
    protected $attendees = array();

    //*** DOCTRINE LAB: configure a many to one relationship to to Event
    /**
     * @ORM\ManyToOne(???)
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
