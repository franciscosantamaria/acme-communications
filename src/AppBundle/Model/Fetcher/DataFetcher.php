<?php

namespace AppBundle\Model\Fetcher;

interface DataFetcher
{
    /**
     * Retrieves all communications for a specific number.
     *
     * @param string $number
     * @param array $types The type of communications to retrieve
     *
     * @return Communication[] A list of communications
     */
    public function getCommunications(string $number, array $types): array;
}
