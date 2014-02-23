<?php

namespace ZfSnapGoogleAdsense\View\Helper;

use ZfSnapGoogleAdsense\Exception;
use ZfSnapGoogleAdsense\View\Helper\Renderer\RendererInterface as Renderer;
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
    private $publisherId;

    /**
     * @var array
     */
    private $ads;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var bool
     */
    private $enable = true;

    /**
     * Max unit units per page
     *
     * @var array
     */
    private $unitLimits = array();

    /**
     * @var array
     */
    private $unitDisplayed = array();

    /**
     * @param string $publisherId
     * @param array $ads
     * @param Renderer $renderer
     */
    public function __construct($publisherId, array $ads, Renderer $renderer)
    {
        if ($publisherId === null) {
            throw new Exception('Missing publisher ID');
        }
        $this->publisherId = $publisherId;
        $this->ads = $ads;
        $this->renderer = $renderer;
    }

    /**
     * @param string $type
     * @param int $limit
     */
    public function setUnitLimit($type, $limit)
    {
        $this->unitLimits[$type] = (int) $limit;
    }

    /**
     * @param string $type
     * @return int
     */
    public function getUnitLimit($type)
    {
        if (!isset($this->unitLimits[$type])) {
            $this->setUnitLimit($type, 0);
        }
        return $this->unitLimits[$type];
    }

    /**
     * @return int
     */
    public function getUnitDisplayed($type)
    {
        if (!isset($this->unitDisplayed[$type])) {
            $this->unitDisplayed[$type] = 0;
        }
        return $this->unitDisplayed[$type];
    }

    /**
     * @param string $type
     */
    private function incrementUnitDisplay($type)
    {
        $unitDisplayed = $this->getUnitDisplayed($type);
        $this->unitDisplayed[$type] = ++$unitDisplayed;
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
     * @param Renderer $renderer
     * @return string
     */
    public function __invoke($ad, Renderer $renderer = null)
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
        return $this->renderAdUnit($ad, $renderer);
    }

    /**
     * @param AdUnit $ad
     * @param Renderer $renderer
     * @return string
     * @throws Exception
     */
    protected function renderAdUnit(AdUnit $ad, Renderer $renderer)
    {
        $type = $ad->getType();
        $unitLimit = $this->getUnitLimit($type);

        if ($unitLimit > 0 && $unitLimit <= $this->getUnitDisplayed($type)) {
            $message = sprintf('Exceeded %s unit limit (%d)', $type, $unitLimit);
            throw new Exception($message);
        }
        $this->incrementUnitDisplay($type);

        return $renderer->render($ad);
    }

    /**
     * @param array $data
     * @return AdUnit
     */
    protected function adFactory(array $data)
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
        $ad = new AdUnit($this->publisherId, $data['id'], $data['name'], $width, $height);

        if (isset($data['type'])) {
            $ad->setType($data['type']);
        }
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
            $ad = $this->ads[$name];
            if (is_array($ad)) {
                if (!isset($ad['name'])) {
                    $ad['name'] = $name;
                }
                $ad = $this->adFactory($ad);
                $this->ads[$name] = $ad;
            }
            if ($ad instanceof AdUnit) {
                return $ad;
            }
            throw new Exception(sprintf('Incorrect ad unit "%s"', $name));
        } else {
            throw new Exception(sprintf('Ad unit "%s" does not exist', $name));
        }
    }

}
