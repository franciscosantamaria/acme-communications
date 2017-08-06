<?php

namespace AppBundle\Model;

use AppBundle\Model\Entity\PhoneSummary;
use AppBundle\Model\Exception\CommunicationsException;
use AppBundle\Model\Exception\FetcherException;
use AppBundle\Model\Exception\InvalidNumberFormat;
use AppBundle\Model\Fetcher\DataFetcher;
use Psr\Log\LoggerInterface;

class CommunicationsManager
{
    /**
     * @var DataFetcher
     */
    private $dataFetcher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    private $types;

    public function __construct(DataFetcher $dataFetcher, LoggerInterface $logger, array $types)
    {
        $this->dataFetcher = $dataFetcher;
        $this->logger = $logger;
        $this->types = $types;
    }

    public function getInfo(string $number): PhoneSummary
    {
        if (!$this->isValidNumber($number)) {
            throw new InvalidNumberFormat();
        }

        try {
            $communications = $this->dataFetcher->getCommunications($number, $this->types);
        } catch (FetcherException $e) {
            $this->logger->error($e->getMessage());
            throw new CommunicationsException();
        }

        return new PhoneSummary($communications);
    }

    private function isValidNumber(string $number): bool
    {
        //TODO I know this is a weak check
        return (preg_match('/^[0-9]{9}$/', $number) === 1) ? true : false;
    }

    public function setTypes(array $types)
    {
        $this->types = $types;
    }
}
