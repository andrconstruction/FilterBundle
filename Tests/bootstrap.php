<?php declare(strict_types = 1);

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require 'vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
