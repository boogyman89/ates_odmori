<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add( 'WhiteOctober\PagerfantaBundle', __DIR__.'/../vendor/bundles' );
$loader->add( 'Pagerfanta'                  , __DIR__.'/../vendor/pagerfanta/src' );

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;