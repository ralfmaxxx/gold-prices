<?php

use AppBundle\AppBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use PSS\SymfonyMockerContainer\DependencyInjection\MockerContainer;
use Sensio\Bundle\DistributionBundle\SensioDistributionBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private const DEV_ENVIRONMENTS = [
        'dev',
    ];

    private const TEST_ENVIRONMENTS = [
        'test',
    ];

    private const PROD_ENVIRONMENT = 'prod';

    private const VAR_CACHE_DIR = '/var/cache/';

    private const VAR_LOGS_DIR = '/var/logs';

    public static function isDevEnvironment(string $environment): bool
    {
        return in_array($environment, self::DEV_ENVIRONMENTS, true);
    }

    public static function isTestEnvironment(string $environment): bool
    {
        return in_array($environment, self::TEST_ENVIRONMENTS, true);
    }

    public static function getProdEnvironment(): string
    {
        return self::PROD_ENVIRONMENT;
    }

    public function registerBundles(): array
    {
        $environment = $this->getEnvironment();

        $bundles = [
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new MonologBundle(),
            new SwiftmailerBundle(),
            new DoctrineBundle(),
            new SensioFrameworkExtraBundle(),
            new DoctrineMigrationsBundle(),
            new AppBundle(),
        ];

        if (self::isTestEnvironment($environment) || self::isDevEnvironment($environment)) {
            array_push(
                $bundles,
                new DebugBundle(),
                new WebProfilerBundle(),
                new SensioDistributionBundle(),
                new SensioGeneratorBundle()
            );
        }

        return $bundles;
    }

    public function getRootDir(): string
    {
        return __DIR__;
    }

    public function getCacheDir(): string
    {
        return dirname(__DIR__) . self::VAR_CACHE_DIR . $this->environment;
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__) . self::VAR_LOGS_DIR;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->environment . '.yml');
    }

    protected function getContainerBaseClass(): string
    {
        return self::isTestEnvironment($this->environment) ?
            MockerContainer::class :
            parent::getContainerBaseClass();
    }
}
