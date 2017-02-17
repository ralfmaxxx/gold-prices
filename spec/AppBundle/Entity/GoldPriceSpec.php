<?php

namespace spec\AppBundle\Entity;

use AppBundle\Entity\GoldPrice;
use DateTime;
use PhpSpec\ObjectBehavior;

/**
 * @mixin GoldPrice
 */
class GoldPriceSpec extends ObjectBehavior
{
    private const DATE = '2017-01-01';

    private const PRICE = 123.11;

    private const EXPECTED_PRICE = 12311;

    private const DATA = [
        'data' => self::DATE,
        'cena' => self::PRICE,
    ];

    private const UUID_REG_EXP = '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/';

    function let()
    {
        $this->beConstructedThroughFrom(self::DATA);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GoldPrice::class);
    }

    function it_has_id()
    {
        $this->getId()->shouldMatch(self::UUID_REG_EXP);
    }

    function it_has_date()
    {
        $this->getDate()->shouldBeLike(new DateTime(self::DATE));
    }

    function it_has_price()
    {
        $this->getPrice()->shouldReturn(self::EXPECTED_PRICE);
    }
}
