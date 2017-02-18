<?php

namespace Tests\AppBundle;

use AppBundle\Http\ClientInterface;
use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Response;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Mockery;
use Tests\AppBundle\Dictionary\KernelAwareDictionaryTrait;

class ApiContext implements KernelAwareContext
{
    use KernelAwareDictionaryTrait;

    private const RELATIVE_DATE_MAPPER = [
        'this year' => 'now',
        'last year' => '-1 year',
        'two years ago' => '-2 years',
        'three years ago' => '-3 years',
        'four years ago' => '-4 years',
        'five years ago' => '-5 years',
        'six years ago' => '-6 years',
        'seven years ago' => '-7 years',
        'eight years ago' => '-8 years',
        'nine years ago' => '-9 years',
        'ten years ago' => '-10 years',
    ];

    private const APP_CLIENT_HTTP_SERVICE_NAME = 'app.client.http';

    private const GOLD_PRICE_PATTERN = '{"data": "%s", "cena": %s}';

    private const API_RESPONSE_PATTERN = '[%s]';

    private const API_EMPTY_COLLECTION = '[]';

    /**
     * @Transform :relativeDate
     */
    public function castRelativeDateToYear(string $relativeDate): string
    {
        return date('Y', strtotime(self::RELATIVE_DATE_MAPPER[$relativeDate]));
    }

    /**
     * @Transform table:api_price,api_date
     */
    public function castGoldPrices(TableNode $goldPricesTable): Response
    {
        $goldPrices = array_map(
            function ($goldPriceRow) {
                return sprintf(self::GOLD_PRICE_PATTERN, $goldPriceRow['api_date'], $goldPriceRow['api_price']);
            },
            $goldPricesTable->getHash()
        );

        $goldPricesApiResponse = sprintf(self::API_RESPONSE_PATTERN, implode(',', $goldPrices));

        return new Response($goldPricesApiResponse);
    }

    /**
     * @Given There are gold prices in API from :relativeDate:
     */
    public function thereAreGoldPricesInApiFrom(string $relativeDate, Response $apiResponse)
    {
        $this
            ->getContainer()
            ->mock(self::APP_CLIENT_HTTP_SERVICE_NAME, ClientInterface::class)
            ->shouldReceive('get')
            ->with(Mockery::on(function (PathAndQuery $pathAndQuery) use ($relativeDate) {
                return $pathAndQuery->get() !== str_replace($relativeDate, '', $pathAndQuery->get());
            }))
            ->andReturn($apiResponse);
    }

    /**
     * @Given There is no data available from :relativeDate
     */
    public function thereIsNoDataAvailableFrom(string $relativeDate)
    {
        $this
            ->getContainer()
            ->mock(self::APP_CLIENT_HTTP_SERVICE_NAME, ClientInterface::class)
            ->shouldReceive('get')
            ->with(Mockery::on(function (PathAndQuery $pathAndQuery) use ($relativeDate) {
                return $pathAndQuery->get() !== str_replace($relativeDate, '', $pathAndQuery->get());
            }))
            ->andReturn(new Response(self::API_EMPTY_COLLECTION));
    }
}
