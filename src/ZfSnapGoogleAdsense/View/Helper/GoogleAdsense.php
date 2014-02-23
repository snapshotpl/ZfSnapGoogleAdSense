<?php

namespace ZfSnapGoogleAdsense\View\Helper;

use ZfSnapGoogleAdsense\View\Helper\Renderer\RendererInterface;
use ZfSnapGoogleAdsense\AdUnit;
use Zend\View\Helper\AbstractHelper;

/**
 * GoogleAdsense view helper
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class GoogleAdsense extends AbstractHelper
{
    const SIZE_DETERMINER = 'x';

    private $id;
    private $ads;
    private $renderer;
    private $enable = true;

    public function __construct($id, array $ads, RendererInterface $renderer)
    {
        $this->id = $id;
        $this->ads = $ads;
        $this->renderer = $renderer;
    }

    public function isEnable()
    {
        return $this->isEnable();
    }

    public function setEnable($enable)
    {
        $this->enable = $enable;
    }

    public function __invoke($ad, RendererInterface $renderer = null)
    {
        if (!$this->isEnable()) {
            return '';
        }
        if ($renderer === null) {
            $renderer = $this->renderer;
        }
        if (is_string($ad)) {
            $ad = $this->getAd($ad);
        }
        return $renderer->render($ad);
    }

    protected function adFactory($name, array $data)
    {
        $size = $data['size'];
        if (is_array($size)) {
            $width = $size['width'];
            $height = $size['height'];
        } else {
            $size = explode(self::SIZE_DETERMINER, $size);
            $width = $size[0];
            $height = $size[1];
        }
        $ad = new AdUnit($this->id, $data['id'], $name, $width, $height);

        return $ad;
    }

    protected function getAd($name)
    {
        if (isset($this->ads[$name])) {
            if (is_array($this->ads[$name])) {
                $ad = $this->adFactory($name, $this->ads[$name]);
                $this->ads[$name] = $ad;
            }
            if ($ad instanceof AdUnit) {
                return $ad;
            }
            throw new Exception('Incorrect ad');
        }
    }

}
