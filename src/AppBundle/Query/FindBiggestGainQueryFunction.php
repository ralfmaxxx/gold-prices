<?php

namespace AppBundle\Query;

use Doctrine\ORM\EntityManagerInterface;

class FindBiggestGainQueryFunction implements QueryFunctionInterface
{
    private const QUERY = '
        SELECT 
            gold_price.price - earlier_gold_price.price AS gain,
            earlier_gold_price.date AS buy_day,
            gold_price.date as sell_day
        FROM gold_price
        LEFT JOIN gold_price as earlier_gold_price
        ON earlier_gold_price.date < gold_price.date
        ORDER BY gain DESC
        LIMIT 1
    ';

    private const RUN_WITHOUT_IMPORT_RESULT = [
        'gain' => 0,
        'buy_day' => 'not enough data',
        'sell_day'=> 'not enough data'
    ];

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    public function __invoke(): array
    {
        $queryStatement = $this
            ->entityManager
            ->getConnection()
            ->prepare(self::QUERY);

        $queryStatement->execute();

        return $queryStatement->fetchAll()[0] ?? self::RUN_WITHOUT_IMPORT_RESULT;
    }
}
