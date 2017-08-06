<?php

namespace spec\AppBundle\Model;

use AppBundle\Model\CommunicationsManager;
use AppBundle\Model\Entity\Communication;
use AppBundle\Model\Entity\PhoneCall;
use AppBundle\Model\Entity\PhoneSummary;
use AppBundle\Model\Exception\CommunicationsException;
use AppBundle\Model\Exception\FetcherException;
use AppBundle\Model\Exception\InvalidNumberFormat;
use AppBundle\Model\Fetcher\DataFetcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class CommunicationsManagerSpec extends ObjectBehavior
{

    function let(DataFetcher $dataFetcher, LoggerInterface $logger)
    {
        $this->beConstructedWith($dataFetcher, $logger, [Communication::CALL]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommunicationsManager::class);
    }

    function it_retrieves_all_info_about_a_phone_number(DataFetcher $dataFetcher)
    {
        $number = '677777879';

        $dataFetcher->getCommunications($number, [Communication::CALL])->willReturn([]);

        $this->getInfo($number)->shouldBeAnInstanceOf(PhoneSummary::class);
    }

    function it_detects_if_the_number_has_an_invalid_format()
    {
        $number = '67777MM79';
        $this->shouldThrow(InvalidNumberFormat::class)->duringGetInfo($number);
    }

    function it_retrieves_the_summary_when_the_user_makes_1_call(DataFetcher $dataFetcher)
    {
        $number = '677777879';
        $dateTime = \DateTime::createFromFormat('dmYHis', '06012016200500');
        $communications = [
            new PhoneCall('677777879', '699233800', Communication::OUTGOING, 'kiko', $dateTime , 30)
        ];

        $dataFetcher->getCommunications($number, [Communication::CALL])->willReturn($communications);

        $expectedSummary = new PhoneSummary($communications);

        $this->getInfo($number)->shouldBeLike($expectedSummary);
    }

    function it_returns_an_error_if_there_was_a_problem_retrieving_the_info(DataFetcher $dataFetcher)
    {
        $number = '677777879';

        $dataFetcher->getCommunications($number, [Communication::CALL])->willThrow(FetcherException::class);

        $this->shouldThrow(CommunicationsException::class)->duringGetInfo($number);
    }
}
