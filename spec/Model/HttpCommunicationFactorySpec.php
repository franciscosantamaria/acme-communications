<?php

namespace spec\AppBundle\Model;

use AppBundle\Model\CommunicationFactory;
use AppBundle\Model\Entity\Communication;
use AppBundle\Model\Entity\PhoneCall;
use AppBundle\Model\Entity\SMS;
use AppBundle\Model\Exception\InvalidCommunicationLineFormat;
use AppBundle\Model\Exception\UnknownCommunicationType;
use AppBundle\Model\HttpCommunicationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpCommunicationFactorySpec extends ObjectBehavior
{
    function it_a_communication_factory()
    {
        $this->shouldImplement(CommunicationFactory::class);
    }

    function it_creates_an_sms_communication()
    {
        $line = 'S7001112226112223331Movistar                02012016180130';

        $dateTime = \DateTime::createFromFormat('dmYHis', '02012016180130');
        $smsCommunication = new SMS('700111222', '611222333', Communication::INCOMING, 'Movistar', $dateTime);

        $this->createCommunication($line)->shouldBeLike($smsCommunication);
    }

    function it_creates_a_phonecall_communication()
    {
        $line = 'C9112223336112223331Mama                    03012016190000000142';

        $dateTime = \DateTime::createFromFormat('dmYHis', '03012016190000');
        $phoneCallCommunication = new PhoneCall('911222333', '611222333', Communication::INCOMING, 'Mama', $dateTime, 142);

        $this->createCommunication($line)->shouldBeLike($phoneCallCommunication);
    }

    function it_detects_if_the_sms_line_is_invalid()
    {
        $line = 'S611222333     14200                        05012016220000';

        $this->shouldThrow(InvalidCommunicationLineFormat::class)->duringCreateCommunication($line);
    }

    function it_detects_if_the_communication_is_different_from_sms_or_phonecall()
    {
        $line = 'U4815162342';

        $this->shouldThrow(UnknownCommunicationType::class)->duringCreateCommunication($line);
    }
}
