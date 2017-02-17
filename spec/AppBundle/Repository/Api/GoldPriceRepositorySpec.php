<?php

namespace spec\AppBundle\Repository\Api;

use AppBundle\Entity\GoldPrice;
use AppBundle\Http\ClientInterface;
use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Response;
use AppBundle\Http\Exception\ClientException;
use AppBundle\Repository\Api\Configuration\PathAndQueryFactory;
use AppBundle\Repository\Api\Exception\RepositoryException;
use AppBundle\Repository\Api\GoldPriceRepository;
use AppBundle\Repository\Api\GoldPriceRepositoryInterface;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin GoldPriceRepository
 */
class GoldPriceRepositorySpec extends ObjectBehavior
{
    private const GOLD_PRICES_AS_STRING = '[{"data":"2017-01-01", "cena": 123.23}]';

    private const INCOMPLETE_GOLD_PRICES_DATA_AS_STRING = '[{"cena": 123.23}]';

    private const IMPROPER_GOLD_PRICES_AS_STRING = 'string  - not json';

    private const GOLD_PRICE_ARRAY = [
        'data' => '2017-01-01',
        'cena' => 123.23,
    ];

    private const INCOMPLETE_GOLD_PRICE_ARRAY = [
        'cena' => 123.23,
    ];

    function let(
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory
    ) {
        $this->beConstructedWith($client, $pathAndQueryFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GoldPriceRepository::class);
        $this->shouldHaveType(GoldPriceRepositoryInterface::class);
    }

    function it_finds_all_gold_prices_for_time_range(
        TimeRangeParameter $timeRangeParameter,
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory,
        PathAndQuery $pathAndQuery,
        Response $response
    ) {
        $pathAndQueryFactory
            ->createFrom($timeRangeParameter)
            ->shouldBeCalled()
            ->willReturn($pathAndQuery);

        $client
            ->get($pathAndQuery)
            ->shouldBeCalled()
            ->willReturn($response);

        $response
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::GOLD_PRICES_AS_STRING);

        $expectedGoldPriceCollection = [
            GoldPrice::from(self::GOLD_PRICE_ARRAY),
        ];

        $this
            ->findAll($timeRangeParameter)
            ->shouldBeLikeGoldPriceCollection($expectedGoldPriceCollection);
    }

    function it_throws_exception_when_client_does_not_succeed(
        TimeRangeParameter $timeRangeParameter,
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory,
        PathAndQuery $pathAndQuery
    ) {
        $pathAndQueryFactory
            ->createFrom($timeRangeParameter)
            ->shouldBeCalled()
            ->willReturn($pathAndQuery);

        $client
            ->get($pathAndQuery)
            ->shouldBeCalled()
            ->willThrow(ClientException::class);

        $this
            ->shouldThrow(RepositoryException::class)
            ->duringFindAll($timeRangeParameter);
    }

    function it_throws_exception_when_can_not_decode_response(
        TimeRangeParameter $timeRangeParameter,
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory,
        PathAndQuery $pathAndQuery,
        Response $response
    ) {
        $pathAndQueryFactory
            ->createFrom($timeRangeParameter)
            ->shouldBeCalled()
            ->willReturn($pathAndQuery);

        $client
            ->get($pathAndQuery)
            ->shouldBeCalled()
            ->willReturn($response);

        $response
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::IMPROPER_GOLD_PRICES_AS_STRING);

        $this
            ->shouldThrow(RepositoryException::coundNotDecode($response->getWrappedObject()))
            ->duringFindAll($timeRangeParameter);
    }

    function it_throws_exception_when_can_not_create_entities(
        TimeRangeParameter $timeRangeParameter,
        ClientInterface $client,
        PathAndQueryFactory $pathAndQueryFactory,
        PathAndQuery $pathAndQuery,
        Response $response
    ) {
        $pathAndQueryFactory
            ->createFrom($timeRangeParameter)
            ->shouldBeCalled()
            ->willReturn($pathAndQuery);

        $client
            ->get($pathAndQuery)
            ->shouldBeCalled()
            ->willReturn($response);

        $response
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::INCOMPLETE_GOLD_PRICES_DATA_AS_STRING);

        $this
            ->shouldThrow(RepositoryException::couldNotCreateEntities([self::INCOMPLETE_GOLD_PRICE_ARRAY]))
            ->duringFindAll($timeRangeParameter);
    }

    public function getMatchers(): array
    {
        return [
            'beLikeGoldPriceCollection' => function (array $returned, array $expected) {
                foreach ($returned as $key => $returnedGoldPrice) {
                    /** @var GoldPrice $returnedGoldPrice */
                    $returnedValues = [$returnedGoldPrice->getDate(), $returnedGoldPrice->getPrice()];

                    /** @var GoldPrice[] $expected */
                    $expectedValues = [$expected[$key]->getDate(), $expected[$key]->getPrice()];

                    if ($returnedValues != $expectedValues) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }
}
