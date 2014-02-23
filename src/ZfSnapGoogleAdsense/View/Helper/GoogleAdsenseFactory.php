<?php

namespace ZfSnapGoogleAdsense\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * GoogleAdsense view helper factory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class GoogleAdsenseFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $config = $sm->get('config');
        $adsenseConfig = $config['zf-snap-google-adsense'];

        $publisherId = $adsenseConfig['publisher-id'];
        $ads = $adsenseConfig['ads'];
        $rendererName = $adsenseConfig['renderer'];
        $enable = $adsenseConfig['enable'];

        $renderer = $sm->get($rendererName);

        $ga = new GoogleAdsense($publisherId, $ads, $renderer);
        $ga->setEnable($enable);

        foreach ($adsenseConfig['unit-limit'] as $type => $limit) {
            $ga->setUnitLimit($type, $limit);
        }

        return $ga;
    }

}
