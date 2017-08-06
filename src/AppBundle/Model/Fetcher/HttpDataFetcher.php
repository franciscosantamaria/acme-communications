<?php

namespace AppBundle\Model\Fetcher;


use AppBundle\Model\CommunicationFactory;
use AppBundle\Model\Exception\FetcherException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;


class HttpDataFetcher implements DataFetcher
{
    /**
     * @var
     */
    private $baseUrl;

    /**
     * @var Client
     */
    private $client;
    /**
     * @var CommunicationFactory
     */
    private $communicationFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * HttpDataFetcher constructor.
     */
    public function __construct($baseUrl, Client $client, CommunicationFactory $communicationFactory, LoggerInterface $logger)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->communicationFactory = $communicationFactory;
        $this->logger = $logger;
    }

    public function getCommunications(string $number, array $types): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUrl . "/communications.$number.log"
            );
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            throw new FetcherException($e->getMessage());
        }

        if ($response->getStatusCode() != 200) {
            throw new FetcherException("Not data found for this number");
        }

        $communications = $this->extractCommunications($response->getBody(), $types);

        return $communications;
    }

    private function extractCommunications(string $rawContent, array $types): array
    {
        $communications = [];

        $lines = explode(PHP_EOL, $rawContent);

        foreach ($lines as $line) {
            if (in_array(substr($line, 0, 1), $types)) {
                try {
                    $communication = $this->communicationFactory->createCommunication($line);
                } catch (FetcherException $e) {
                    $this->logger->error($e->getMessage());
                }
                $communications[] = $communication;
            }
        }

        return $communications;
    }
}
