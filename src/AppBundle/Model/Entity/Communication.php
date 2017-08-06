<?php

namespace AppBundle\Model\Entity;


class Communication
{
    const SMS = 'S';
    const CALL = 'C';
    const INCOMING = 'incoming';
    const OUTGOING = 'outgoing';

    protected $type;
    protected $sender;
    protected $receiver;
    protected $contactName;
    protected $dateTime;
    private $duration;
    private $communicationType;

    /**
     * PhoneCall constructor.
     */
    public function __construct($type, $sender, $receiver, $communicationType, $contactName, $dateTime, $duration = null)
    {
        $this->type = $type;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->communicationType = $communicationType;
        $this->contactName = $contactName;
        $this->dateTime = $dateTime;
        $this->duration = $duration;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getReceiver(): string
    {
        return $this->receiver;
    }

    /**
     * @return mixed
     */
    public function getContactName(): string
    {
        return $this->contactName;
    }

    /**
     * @return mixed
     */
    public function getCommunicationType(): string
    {
        return $this->communicationType;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }
}
