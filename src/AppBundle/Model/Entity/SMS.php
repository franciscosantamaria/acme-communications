<?php

namespace AppBundle\Model\Entity;


class SMS extends Communication
{
    /**
     * PhoneCall constructor.
     */
    public function __construct($sender, $receiver, $communicationType, $contactName, $dateTime)
    {
        parent::__construct('sms', $sender, $receiver, $communicationType, $contactName, $dateTime);
    }
}
