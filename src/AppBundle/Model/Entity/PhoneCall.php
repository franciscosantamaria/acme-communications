<?php

namespace AppBundle\Model\Entity;


class PhoneCall extends Communication
{
    /**
     * PhoneCall constructor.
     */
    public function __construct($sender, $receiver, $communicationType, $contactName, $dateTime, $duration)
    {
        parent::__construct('call', $sender, $receiver, $communicationType, $contactName, $dateTime, $duration);
    }
}
