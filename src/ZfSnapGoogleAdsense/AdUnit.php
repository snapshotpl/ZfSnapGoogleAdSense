<?php

namespace ZfSnapGoogleAdsense;

/**
 * AdUnit
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class AdUnit
{
    /**
     * @var string
     */
    private $partnerId;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var string
     */
    private $id;

    /**
     * @var name
     */
    private $name;

    /**
     * @param string $partnerId
     * @param string $id
     * @param string $name
     * @param int $width
     * @param int $height
     */
    public function __construct($partnerId, $id, $name, $width, $height)
    {
        $this->partnerId = $partnerId;
        $this->id = $id;
        $this->name = $name;
        $this->width = (int) $width;
        $this->height = (int) $height;
    }

    /**
     * @return string
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
