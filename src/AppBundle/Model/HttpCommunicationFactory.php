<?php

namespace AppBundle\Model;


use AppBundle\Model\Entity\Communication;
use AppBundle\Model\Entity\PhoneCall;
use AppBundle\Model\Entity\SMS;
use AppBundle\Model\Exception\InvalidCommunicationLineFormat;
use AppBundle\Model\Exception\UnknownCommunicationType;

class HttpCommunicationFactory extends CommunicationFactory
{
    public function createCommunication($content): Communication
    {
        $type = substr($content, 0, 1);

        $content = substr($content, 1);

        switch ($type) {
            case Communication::CALL:
                $fields = $this->detectFields($type, $content);

                return new PhoneCall(
                    $fields['sender'],
                    $fields['receiver'],
                    $fields['comType'] === 0 ? Communication::OUTGOING: Communication::INCOMING,
                    trim($fields['contactName']),
                    \DateTime::createFromFormat('dmYHis', $fields['dateTime']),
                    ltrim($fields['duration'],'0')
                );
            case Communication::SMS:
                $fields = $this->detectFields($type, $content);

                return new SMS(
                    $fields['sender'],
                    $fields['receiver'],
                    $fields['comType'] === 0 ? Communication::OUTGOING: Communication::INCOMING,
                    trim($fields['contactName']),
                    \DateTime::createFromFormat('dmYHis', $fields['dateTime'])
                );
            default:
                throw new UnknownCommunicationType("There is no communication type for the type $type");
        };
    }

    /**
     * Extracts the fields from a log's line.
     *
     * @throws InvalidCommunicationLineFormat If the line has an incorrect format
     */
    private function detectFields(string $type, string $content): array
    {
        switch ($type) {
            case Communication::CALL:
                $regexp = '/(?<sender>[0-9]{9})(?P<receiver>[0-9]{9})(?P<comType>[0,1]{1})(?P<contactName>[\s\S]{24})(?P<dateTime>[0-9]{14})(?P<duration>[0-9]{6})/';
                break;
            case Communication::SMS:
                $regexp = '/(?<sender>[0-9]{9})(?P<receiver>[0-9]{9})(?P<comType>[0,1]{1})(?P<contactName>[\s\S]{24})(?P<dateTime>[0-9]{14})/';
                break;
        }

        preg_match_all($regexp, $content, $matches);

        $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

        $fields = array_map(
            function($n) {
                if (empty($n)) {
                    throw new InvalidCommunicationLineFormat("The line doesn't have the correct format");
                }
                return $n[0];
            },
            $matches
        );

        return $fields;
    }
}
