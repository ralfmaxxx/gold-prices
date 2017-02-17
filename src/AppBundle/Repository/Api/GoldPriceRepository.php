<?php

namespace AppBundle\Repository\Api;

use AppBundle\Entity\GoldPrice;
use AppBundle\Http\ClientInterface;
use AppBundle\Http\Exception\ClientException;
use AppBundle\Repository\Api\Configuration\PathAndQueryFactory;
use AppBundle\Repository\Api\Exception\RepositoryException;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use InvalidArgumentException;

class GoldPriceRepository implements GoldPriceRepositoryInterface
{
    private $client;

    private $pathAndQueryFactory;

    public function __construct(
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory
    ) {
        $this->client = $client;
        $this->pathAndQueryFactory = $pathAndQueryFactory;
    }

    public function findAll(TimeRangeParameter $timeRangeParameter): array
    {
        try {
            $response = $this->client->get(
                $this->pathAndQueryFactory->createFrom($timeRangeParameter)
            );

            $asArray = true;
            $responseArray = json_decode($response->get(), $asArray);

            if ($responseArray === null) {
                throw RepositoryException::coundNotDecode($response);
            }

            return array_map(
                function (array $goldPriceArray) {
                    return GoldPrice::from($goldPriceArray);
                },
                $responseArray
            );
        } catch (ClientException $exception) {
            throw RepositoryException::from($exception);
        } catch (InvalidArgumentException $exception) {
            throw RepositoryException::couldNotCreateEntities($responseArray);
        }
    }
}
