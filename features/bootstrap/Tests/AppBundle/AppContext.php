<?php

namespace Tests\AppBundle;

use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Mockery;
use RuntimeException;
use Tests\AppBundle\Dictionary\KernelAwareDictionaryTrait;

class AppContext implements KernelAwareContext
{
    use KernelAwareDictionaryTrait;

    const METHOD_GET_CONTAINER_MUST_EXIST = 'Method "getContainer" must exist in $this context';

    private function checkDependencies()
    {
        if (!method_exists($this, 'getContainer')) {
            throw new RuntimeException(self::METHOD_GET_CONTAINER_MUST_EXIST);
        }
    }

    /**
     * @BeforeScenario
     */
    public function clearDatabase()
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $purger = new ORMPurger($entityManager);
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->purge();

        $entityManager->clear();
    }

    /**
     * @AfterScenario
     */
    public function unmockServices()
    {
        $this->checkDependencies();

        $serviceIds = array_keys($this->getContainer()->getMockedServices());

        foreach ($serviceIds as $id) {
            $this->getContainer()->unmock($id);
        }

        Mockery::close();
    }
}
