<?php

namespace AppBundle\Model\Entity;


class PhoneSummary
{
    /**
     * @var Communication[]|array
     */
    private $communications;

    /**
     * @param Communication[] $communications
     */
    public function __construct(array $communications)
    {
        $this->communications = $communications;
    }

    public function getCommunicationsGroupedByContact(): array
    {
        $contacts = [];

        foreach ($this->communications as $communication) {
            if (($contact = $this->getContact($communication->getContactName(), $contacts)) != null) {
                $contact->addCommunication($communication);
            } else {
                $contact = new Contact($communication->getContactName());
                $contact->addCommunication($communication);
                $contacts[] = $contact;
            }
        }

        return $contacts;
    }

    private function getContact(string $contactName, array $contacts)
    {
        foreach ($contacts as $contact) {
            if ($contact->getName() == $contactName) {
                return $contact;
            }
        }

        return null;
    }
}
