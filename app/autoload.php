<?php
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('', __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
    $loader->add('Stfalcon', __DIR__.'/../vendor/bundles');
}

//integrade Zend framework
$loader->add('Zend', __DIR__.'/../vendor/Zend/library');
set_include_path(__DIR__.'/../vendor/Zend/library'. PATH_SEPARATOR.get_include_path());

//autoload RssService class for Zend web service
set_include_path(__DIR__.'/../src/SM/Bundle/SoapBundle/WebServices'. PATH_SEPARATOR.get_include_path());

//integrade nusoap
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
