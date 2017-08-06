<?php

namespace spec\AppBundle\Model\Entity;

use AppBundle\Model\Entity\Communication;
use AppBundle\Model\Entity\Contact;
use AppBundle\Model\Entity\PhoneCall;
use AppBundle\Model\Entity\PhoneSummary;
use AppBundle\Model\Entity\SMS;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhoneSummarySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PhoneSummary::class);
    }

    function it_returns_the_list_of_communications_grouped_by_contacts()
    {
        $sms1 = new SMS('677776655', '611223344', Communication::OUTGOING, 'Kiko', \DateTime::createFromFormat('dmYHis', '06012016200500'));
        $phonecall1 = new PhoneCall('677776655', '655788900', Communication::OUTGOING, 'Ana', \DateTime::createFromFormat('dmYHis', '06112016200500'), 120);
        $sms2 = new SMS('611223344', '677776655', Communication::INCOMING, 'Kiko', \DateTime::createFromFormat('dmYHis', '07012016200500'));

        $communications = [
            $sms1,
            $phonecall1,
            $sms2
        ];

        $kiko = new Contact('Kiko');
        $kiko->addCommunication($sms1);
        $kiko->addCommunication($sms2);

        $ana = new Contact('Ana');
        $ana->addCommunication($phonecall1);

        $expectedResults = [$kiko, $ana];

        $this->beConstructedWith($communications);

        $this->getCommunicationsGroupedByContact()->shouldBeLike($expectedResults);
    }
}
