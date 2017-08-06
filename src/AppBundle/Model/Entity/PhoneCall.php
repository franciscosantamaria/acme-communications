<?php

namespace AppBundle\Model\Entity;


class PhoneCall extends Communication
{
    public function __construct(
        string $sender,
        string $receiver,
        string $communicationType,
        string $contactName,
        \DateTimeInterface $dateTime,
        int $duration
    ) {
        parent::__construct('call', $sender, $receiver, $communicationType, $contactName, $dateTime, $duration);
    }
}
