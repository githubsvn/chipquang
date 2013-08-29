<?php

namespace SM\Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * SMAdminBundle
 */
class SMAdminBundle extends Bundle
{

    private static $containerInstance = null;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        parent::setContainer($container);
        self::$containerInstance = $container;
    }

    /**
     * @return type
     */
    public static function getContainer()
    {
        return self::$containerInstance;
    }

}
