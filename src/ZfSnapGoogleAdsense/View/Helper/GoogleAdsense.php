<?php

namespace ZfSnapGoogleAdsense\View\Helper;

use ZfSnapGoogleAdsense\View\Helper\Renderer\RendererInterface;
use ZfSnapGoogleAdsense\Model\AdUnit;
use Zend\View\Helper\AbstractHelper;

/**
 * GoogleAdsense view helper
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class GoogleAdsense extends AbstractHelper
{
    const SIZE_DETERMINER = 'x';

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $ads;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var bool
     */
    private $enable = true;

    /**
     * @param string $id
     * @param array $ads
     * @param RendererInterface $renderer
     */
    public function __construct($id, array $ads, RendererInterface $renderer)
    {
        $this->id = $id;
        $this->ads = $ads;
        $this->renderer = $renderer;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
    }

    /**
     * @param string|AdUnit $ad
     * @param RendererInterface $renderer
     * @return string
     */
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

    /**
     * @param string $name
     * @param array $data
     * @return AdUnit
     */
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

    /**
     * @param string $name
     * @return AdUnit
     * @throws Exception
     */
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
