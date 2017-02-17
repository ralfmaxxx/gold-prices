<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\GoldPrice;
use AppBundle\Repository\ORM\Exception\RepositoryException;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;

class GoldPriceRepository extends EntityRepository implements GoldPriceRepositoryInterface
{
    public function save(GoldPrice $goldPrice)
    {
        $entityManager = $this->getEntityManager();

        try {
            $entityManager->persist($goldPrice);
            $entityManager->flush();
        } catch (ORMInvalidArgumentException|OptimisticLockException $exception) {
            throw RepositoryException::couldNotSave($goldPrice);
        }
    }

    public function findOneByDate(DateTime $date): ?GoldPrice
    {
        return parent::findOneBy([
            'date' => $date
        ]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
