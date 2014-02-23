<?php

namespace ZfSnapGoogleAdsense;

/**
 * AdUnit
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class AdUnit
{
    private $partnerId;
    private $width;
    private $height;
    private $id;
    private $name;

    public function __construct($partnerId, $id, $name, $width, $height)
    {
        $this->partnerId = $partnerId;
        $this->id = $id;
        $this->name = $name;
        $this->width = (int) $width;
        $this->height = (int) $height;
    }

    public function getPartnerId()
    {
        return $this->partnerId;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

}
