<?php

namespace AppBundle\Model\Entity;


class Contact
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Communication[]
     */
    private $communications = [];

    /**
     * Contact constructor.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addCommunication(Communication $communication)
    {
        $this->communications[] = $communication;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getCommunications(): array
    {
        return $this->communications;
    }
}
