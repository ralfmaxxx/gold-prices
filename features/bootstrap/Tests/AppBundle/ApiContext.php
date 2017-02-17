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

    private const APP_CLIENT_HTTP_SERVICE_NAME = 'app.client.http';

    private const GOLD_PRICE_PATTERN = '{"data": "%s", "cena": %s}';

    private const API_RESPONSE_PATTERN = '[%s]';

    private const API_EMPTY_COLLECTION = '[]';

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
     * @Given There are gold prices in API for year :year:
     */
    public function thereAreGoldPricesInApiForYear(int $year, Response $apiResponse)
    {
        $this
            ->getContainer()
            ->mock(self::APP_CLIENT_HTTP_SERVICE_NAME, ClientInterface::class)
            ->shouldReceive('get')
            ->with(Mockery::on(function (PathAndQuery $pathAndQuery) use ($year) {
                return $pathAndQuery->get() !== str_replace($year, '', $pathAndQuery->get());
            }))
            ->andReturn($apiResponse);
    }

    /**
     * @Given There is no data available for year :year
     */
    public function thereIsNoDataAvailableForYear(int $year)
    {
        $this
            ->getContainer()
            ->mock(self::APP_CLIENT_HTTP_SERVICE_NAME, ClientInterface::class)
            ->shouldReceive('get')
            ->with(Mockery::on(function (PathAndQuery $pathAndQuery) use ($year) {
                return $pathAndQuery->get() !== str_replace($year, '', $pathAndQuery->get());
            }))
            ->andReturn(new Response(self::API_EMPTY_COLLECTION));
    }
}
