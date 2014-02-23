<?php

use \ZfSnapGoogleAdsense\Model\AdUnit;

return array(
    'zf-snap-google-adsense' => array(
        'ads' => array(),
        'enable' => true,
        'publisher-id' => null,
        'renderer' => 'zf-snap-google-adsense-renderer-view-asynchronous',
        'unit-limit' => array(
            AdUnit::TYPE_CONTENT => 3,
            AdUnit::TYPE_LINK => 3,
        ),
        'renderers' => array(
            'zf-snap-google-adsense-renderer-view-placeholdit' => array(
                'params' => array(
                    'useAdNameToText' => true,
                    'backgroundColor' => 'ccc',
                    'textColor' => '969696',
                    'format' => 'gif',
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'ZfSnapGoogleAdsense\View\Helper\Renderer\ViewFactory' => 'ZfSnapGoogleAdsense\View\Helper\Renderer\ViewFactory',
        ),
    ),
    'view_helpers' => array(
        'aliases' => array(
            'adsense' => 'googleAdsense',
        ),
        'factories' => array(
            'googleAdsense' => 'ZfSnapGoogleAdsense\View\Helper\GoogleAdsenseFactory',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf-snap-google-adsense-renderer-view-asynchronous' => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/asynchronous.phtml',
            'zf-snap-google-adsense-renderer-view-placeholdit'  => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/placeholdit.phtml',
            'zf-snap-google-adsense-renderer-view-synchronous'  => __DIR__ . '/../view/zf-snap-google-adsense/renderer/view/synchronous.phtml',
        ),
    ),
);