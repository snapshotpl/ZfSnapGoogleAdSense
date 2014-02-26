ZfSnapGoogleAdSense [![Build Status](https://travis-ci.org/snapshotpl/ZfSnapGoogleAdSense.png?branch=1.0.0)](https://travis-ci.org/snapshotpl/ZfSnapGoogleAdSense) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/snapshotpl/ZfSnapGoogleAdSense/badges/quality-score.png?s=9f9e8109533cadafa60dc90839c8edae02f85802)](https://scrutinizer-ci.com/g/snapshotpl/ZfSnapGoogleAdSense/)
===================

Google AdSense view helper for Zend Framework 2

Module helps to manage yours AdSense units on page. Keep them all in one place and use renderers!

The simplest usage
--------------
Add ad unit (one or more) and publisher ID (you can [`find it here`](https://www.google.com/adsense/app#accountInformation)) to your config:

```php
return array(
  'zf-snap-google-adsense' => array(
    'publisher-id' => 'pub-1234567890123456',
    'ads' => array(
      'home-page' => array(
        'id' => 1234567890,
        'size' => '336x280',
      ),
    ),
  ),
);
```

And then render ad in your view by view helper. You can use googleAdsense or adsense name:

```php
echo $this->adsense('home-page');
```
That's all!
In default adsense use asynchronous code. You can change it by using predefined view renderers.

How to install?
---------------

Via [`composer`](https://getcomposer.org/)
```json
{
  "require": {
    "snapshotpl/zf-snap-google-adsense": "1.*"
  }
}
```

Renderers
--------

You can use renderes (by implements `ZfSnapGoogleAdSense\View\Helper\Renderer\RendererInterface`) to render your ads. In default module provides simple view renderer with very useful views:
* **asynchronous** (default): official asynchronous script,
* **synchronous**: official synchronous script,
* **placeholdit**: fake placeholer is using [`placehold.it`](http://placehold.it/) service to generate image, perfect for dev or test eviroments, you can customize it, to details see `config/module.config.php` and overwrite options,
* **html**: generates html div, perfect for dev or test eviroments, you can customize it, to details see `config/module.config.php` and overwrite options,

To add own view to view render create view (in view you can use `ad` property which it's instance of `\ZfSnapGoogleAdSense\Model\AdUnit` by default) add it to view_manager with prefix `zf-snap-google-adsense-renderer-view-*`:

```php
return array(
  'view_manager' => array(
    'template_map' => array(
      'zf-snap-google-adsense-renderer-view-customview' => __DIR__ . '/my-awesome-custom-view.phtml',
    ),
  ),
);
```

To change current view renderer pass view name to `renderer` option:

```php
return array(
  'zf-snap-google-adsense' => array(
    'renderer' => 'zf-snap-google-adsense-renderer-view-customview',
  ),
);
```

If you wrote your own renderer pass intance name from `service_manager`. You can also set custom parameters into view. To see how it works look into `renderers` array in `config/module.config.php` and view renderers source.

Options
-------

`ads` defines ad units
* **id** (required): Ad ID,
* **size** (required): You can define size by string or array,
* **type**: content and link. Content unit is default. You can use constats or strings,
* **name**: It's used in custom renderes (placeholdit and html). If name is not defined, ad gets name by key name,

```php
return array(
  'zf-snap-google-adsense' => array(
    'ads' => array(
      'link-ad-by-constat' => array(
        'id' => 1234567890,
        'size' => '336x280',
        'type' => \ZfSnapGoogleAdSense\Model\AdUnit::TYPE_LINK,
      ),
      'link-ad-by-string' => array(
        'id' => 1234567890,
        'size' => array(
          'width' => 336,
          'height' => 280,
        ),
        'type' => 'link',
      ),
      'content-ad' => array(
        'id' => 1234567890,
        'size' => '336x280',
        'type' => \ZfSnapGoogleAdSense\Model\AdUnit::TYPE_CONTENT,
        'name' => 'Content ad under header',
      ),
    ),
  ),
);
```

`enable` if equals `false`, than disable ads on page.

```php
return array(
  'zf-snap-google-adsense' => array(
    'enable' => false,
  ),
);
```

`publisher-id` (required) publisher ID - you can [`find it here`](https://www.google.com/adsense/app#accountInformation)

`unit-limit` limits ads on page. Default values:
* 3 content units ([`more info`](https://support.google.com/adsense/answer/1346295#Google_ad_limit_per_page))
* 3 link units ([`more info`](https://support.google.com/adsense/answer/1346295#Google_link_unit_limit_per_page))

```php
return array(
  'zf-snap-google-adsense' => array(
    'unit-limit' => array(
      AdUnit::TYPE_CONTENT => 3,
      AdUnit::TYPE_LINK => 3,
    ),
  ),
);
```
