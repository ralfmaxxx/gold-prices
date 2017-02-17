<?php

namespace Tests\AppBundle\Dictionary;

use PSS\SymfonyMockerContainer\DependencyInjection\MockerContainer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait KernelAwareDictionaryTrait
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @return ContainerInterface|MockerContainer
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
