<?php

namespace AppBundle\Command;

use AppBundle\Generator\GeneratorInterface;
use AppBundle\Repository\Api\Exception\RepositoryException as ApiRepositoryException;
use AppBundle\Repository\Api\GoldPriceRepositoryInterface as ApiGoldPriceRepositoryInterface;
use AppBundle\Repository\ORM\Exception\RepositoryException as ORMRepositoryException;
use AppBundle\Repository\ORM\GoldPriceRepositoryInterface as ORMGoldPriceRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GoldPricesImporterCommand extends Command
{
    private const COMMAND_NAME = 'app:gold_prices:importer';
    private const COMMAND_DESCRIPTION = 'Imports prices into database';

    private const SUCCESS_EXIT_CODE = 0;

    private $timeRangeParameterGenerator;

    private $apiGoldPriceRepository;

    private $ormGoldPriceRepository;

    public function __construct(
        GeneratorInterface $timeRangeParameterGenerator,
        ApiGoldPriceRepositoryInterface $apiGoldPriceRepository,
        ORMGoldPriceRepositoryInterface $ormGoldPriceRepository
    ) {
        $this->timeRangeParameterGenerator = $timeRangeParameterGenerator;
        $this->apiGoldPriceRepository = $apiGoldPriceRepository;
        $this->ormGoldPriceRepository = $ormGoldPriceRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->timeRangeParameterGenerator->get() as $timeRangeParameter) {
            try {
                foreach ($this->apiGoldPriceRepository->findAll($timeRangeParameter) as $goldPrice) {
                    $this->ormGoldPriceRepository->save($goldPrice);
                }
            } catch (ApiRepositoryException|ORMRepositoryException $exception) {
                $output->writeln($exception->getMessage());
            }
        }

        return self::SUCCESS_EXIT_CODE;
    }
}
