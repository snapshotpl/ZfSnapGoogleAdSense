<?php

namespace ZfSnapGoogleAdsense\View\Helper\Renderer;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceManager;

/**
 * Description of ViewFactory
 *
 * @author witold
 */
class ViewFactory implements AbstractFactoryInterface {

    const PREFIX = 'google-adsense-renderer-';
    const PREFIX_LENGTH = 24;

    public function canCreateServiceWithName(ServiceManager $sm, $name, $requestedName) {
        return substr($requestedName, 0, self::PREFIX_LENGTH) === self::PREFIX;
    }

    public function createServiceWithName(ServiceManager $sm, $name, $requestedName) {
        $config = $sm->get('config');
        $viewRenderer = $sm->get('ViewRenderer');
        $template = $requestedName;
        $params = array();

        if (isset($config['google-adsense']['renderers'][$requestedName])) {
            $data = $config['google-adsense']['renderers'][$requestedName];

            if (isset($data['template'])) {
                $template = $data['template'];
            }
            if (isset($data['params'])) {
                $params = $data['params'];
            }
        }
        $renderer = new View($viewRenderer, $template, $params);

        return $renderer;
    }

}
