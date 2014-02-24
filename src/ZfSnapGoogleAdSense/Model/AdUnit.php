<?php

namespace ZfSnapGoogleAdSense\Model;

/**
 * AdUnit
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class AdUnit
{
    const TYPE_CONTENT = 'content';
    const TYPE_LINK = 'link';

    /**
     * @var string
     */
    private $publisherId;

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
     * @var string
     */
    private $type = self::TYPE_CONTENT;

    /**
     * @param string $publisherId
     * @param string $id
     * @param string $name
     * @param int $width
     * @param int $height
     */
    public function __construct($publisherId, $id, $name, $width, $height)
    {
        $this->publisherId = $publisherId;
        $this->id = $id;
        $this->name = $name;
        $this->width = (int) $width;
        $this->height = (int) $height;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Is type unit?
     *
     * @return bool
     */
    public function isType($type)
    {
        return $this->getType() === $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPublisherId()
    {
        return $this->publisherId;
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
