<?php

namespace ZfSnapGoogleAdSense\View\Helper\Renderer;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceManager;

/**
 * View renderer factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ViewFactory implements AbstractFactoryInterface
{
    const PREFIX = 'zf-snap-google-adsense-renderer-view-';
    const PREFIX_LENGTH = 37;

    /**
     * @param ServiceManager $sm
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceManager $sm, $name, $requestedName)
    {
        return substr($requestedName, 0, self::PREFIX_LENGTH) === self::PREFIX;
    }

    /**
     * @param ServiceManager $sm
     * @param string $name
     * @param string $requestedName
     * @return View
     */
    public function createServiceWithName(ServiceManager $sm, $name, $requestedName)
    {
        $config = $sm->get('config');
        $viewRenderer = $sm->get('ViewRenderer');
        /* @var $viewRenderer \Zend\View\Renderer\PhpRenderer */
        $template = $requestedName;
        $params = array();

        if (isset($config['zf-snap-google-adsense']['renderers'][$requestedName])) {
            $data = $config['zf-snap-google-adsense']['renderers'][$requestedName];

            if (isset($data['template'])) {
                $template = $data['template'];
            }
            if (isset($data['params'])) {
                $params = $data['params'];
            }
        }
        return new View($viewRenderer, $template, $params);
    }
}
