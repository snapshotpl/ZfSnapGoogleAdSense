<?php

namespace ZfSnapGoogleAdsense\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of GoogleAdsenseFactory
 *
 * @author witold
 */
class GoogleAdsenseFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $sl) {

        $sm = $sl->getServiceLocator();
        $config = $sm->get('config');
        $adsenseConfig = $config['google-adsense'];

        $id = $adsenseConfig['id'];
        $ads = $adsenseConfig['ads'];
        $rendererName = $adsenseConfig['renderer'];
        $enable = $adsenseConfig['enable'];

        $renderer = $sm->get($rendererName);

        $ga = new GoogleAdsense($id, $ads, $renderer);
        $ga->setEnable($enable);

        return $ga;
    }

}
