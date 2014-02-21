<?php

return array(
    'google-adsense' => array(
        'ads' => array(
            'home-page' => array(
                'id' => '8065930360',
                'size' => '320x100',
            ),
        ),
        'enable' => true,
        'id' => 'pub-1348097528006754',
        'renderer' => 'google-adsense-renderer-placeholdit',
        'renderers' => array(
            'google-adsense-renderer-placeholdit' => array(
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
            'google-adsense-renderer-asynchronous' => __DIR__ . '/../view/google-adsense/renderer/asynchronous.phtml',
            'google-adsense-renderer-placeholdit'  => __DIR__ . '/../view/google-adsense/renderer/placeholdit.phtml',
            'google-adsense-renderer-synchronous'  => __DIR__ . '/../view/google-adsense/renderer/synchronous.phtml',
        ),
    ),
);