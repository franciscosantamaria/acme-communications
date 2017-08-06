<?php

namespace AppBundle\Model\Entity;


class SMS extends Communication
{
    public function __construct(
        string $sender,
        string $receiver,
        string $communicationType,
        string $contactName,
        \DateTimeInterface $dateTime
    ) {
        parent::__construct('sms', $sender, $receiver, $communicationType, $contactName, $dateTime);
    }
}
