<?php

/*itt próbáltam a karakterhiba okát megtalálni....elméletileg mivel die() funkcióban nincsen hiba ,így nem a php verzió, hanem valamely általad használt html szűrő okozza a difit....
skype: halalosztag ezen a csatornán szyvesen segítek megtalálni a konkrét hiba okát illetve a megoldást(megjegyzem php7-ben magam sem vagyok teljesen jártas, de a barátaimat felhasználva tuti sikeresek leszünk:) */
/*die("árvíztürőtükörfúrógép".phpinfo());*/
use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$kernel = new AppKernel('prod', false);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
