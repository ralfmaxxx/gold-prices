<?php

namespace AppBundle\DependencyInjection;

use IteratorAggregate;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AppExtension extends Extension
{
    private const BUNDLE_SERVICE_PATH = __DIR__ . '/../Resources/config/services';

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(self::BUNDLE_SERVICE_PATH));
        $finder = new Finder();

        $this->loadServices($finder, $loader);
    }

    private function loadServices(Finder $finder, LoaderInterface $loader)
    {
        $serviceFiles = $this->getServiceFiles($finder)->name('*.yml');

        $this->loadFiles($loader, $serviceFiles);
    }

    private function loadFiles(LoaderInterface $loader, IteratorAggregate $files)
    {
        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $loader->load($file->getRelativePathname());
        }
    }

    private function getServiceFiles(Finder $finder): Finder
    {
        return $finder->create()->files()->in(self::BUNDLE_SERVICE_PATH);
    }
}
