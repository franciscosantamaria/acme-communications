<?php

namespace AppBundle\Model;


use AppBundle\Model\Entity\Communication;

abstract class CommunicationFactory
{
    /**
     * Returns a new Communication object
     *
     * @param $content The content that will be used to select the communication object to return
     *
     * @return Communication
     */
    abstract public function createCommunication($content): Communication;
}
