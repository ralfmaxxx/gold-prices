<?php

namespace Tests\AppBundle;

use AppBundle\Entity\GoldPrice;
use AppBundle\Repository\ORM\GoldPriceRepositoryInterface;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\AppBundle\Dictionary\KernelAwareDictionaryTrait;

class DataContext implements KernelAwareContext
{
    use KernelAwareDictionaryTrait;

    /**
     * @Transform :date
     */
    public function castStringToDateTime(string $date): DateTime
    {
        return new DateTime($date);
    }

    /**
     * @Transform table:orm_price,orm_date
     *
     * @return GoldPrice[]
     */
    public function castGoldPrices(TableNode $goldPricesTable): array
    {
        return array_map(
            function (array $goldPriceRow) {
                return GoldPrice::from([
                    'cena' => $goldPriceRow['orm_price'],
                    'data' => $goldPriceRow['orm_date']
                ]);
            },
            $goldPricesTable->getHash()
        );
    }

    /**
     * @Given There are gold prices in database:
     *
     * @param GoldPrice[] $goldPrices
     */
    public function thereAreGoldPricesInDatabase(array $goldPrices)
    {
        /** @var GoldPriceRepositoryInterface $ormGoldPriceRepository */
        $ormGoldPriceRepository = $this->getContainer()->get('app.repository.orm.gold_price');

        foreach ($goldPrices as $goldPrice) {
            $ormGoldPriceRepository->save($goldPrice);
        }
    }

    /**
     * @Then I should have gold price from :date imported
     *
     * @throws ExpectationFailedException
     */
    public function iShouldHaveGoldPriceFromImported(DateTime $date)
    {
        $ormGoldPriceRepository = $this->getContainer()->get('app.repository.orm.gold_price');

        Assert::assertInstanceOf(GoldPrice::class, $ormGoldPriceRepository->findOneByDate($date));
    }

    /**
     * @Then I should have :number gold prices imported
     *
     * @throws ExpectationFailedException
     */
    public function iShouldHaveGoldPricesImported(int $number)
    {
        /** @var GoldPriceRepositoryInterface $ormGoldPriceRepository */
        $ormGoldPriceRepository = $this->getContainer()->get('app.repository.orm.gold_price');

        Assert::assertEquals($number, count($ormGoldPriceRepository->findAll()));
    }
}
