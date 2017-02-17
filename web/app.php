<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

define('SYMFONY_ENV', getenv('SYMFONY_ENV') ? : AppKernel::getProdEnvironment());
$isDevEnv = AppKernel::isDevEnvironment(SYMFONY_ENV);

if ($isDevEnv) {
    Debug::enable();
}

$kernel = new AppKernel(SYMFONY_ENV, $isDevEnv);
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
