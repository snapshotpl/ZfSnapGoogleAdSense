<?php

use ZfSnapGoogleAdSense\View\Helper\GoogleAdSense;
use ZfSnapGoogleAdSense\Model\AdUnit;

/**
 * GoogleAdsenseTest
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class GoogleAdsenseTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var GoogleAdSense
     */
    protected $ga;

    protected $publisherId;

    protected function setUp()
    {
        $this->publisherId = 'pub-123456789';
        $ads = $this->getAds();

        $renderer = $this->getMock('\ZfSnapGoogleAdSense\View\Helper\Renderer\RendererInterface');
        $renderer->expects($this->any())
                ->method('render')
                ->will($this->returnValue('default'));

        $this->ga = new GoogleAdSense($this->publisherId, $ads, $renderer);
    }

    private function getAds()
    {
        return array(
            'simplest' => array(
                'id' => '12334234',
                'size' => '320x100',
            ),
            'second' => array(
                'id' => '987654321',
                'size' => array(
                    'width' => 200,
                    'height' => 300,
                ),
                'name' => 'custom name',
                'type' => AdUnit::TYPE_LINK,
            ),
            'linktype' => array(
                'id' => '675849321',
                'size' => array(
                    'width' => 100,
                    'height' => 600,
                ),
                'type' => AdUnit::TYPE_LINK,
            ),
        );
    }

    public function testIsEnable()
    {
        $ga = $this->ga;

        $this->assertTrue($ga->isEnable());

        $ga->setEnable(false);
        $this->assertTrue(!$ga->isEnable());

        $ga->setEnable(true);
        $this->assertTrue($ga->isEnable());

        $ga->setEnable(null);
        $this->assertTrue(!$ga->isEnable());

        $ga->setEnable(1);
        $this->assertTrue($ga->isEnable());
    }

    public function testRender()
    {
        $ga = $this->ga;
        $this->assertEquals('default', $ga('simplest'));
    }

    public function testCustomRenderer()
    {
        $renderer = $this->getMock('\ZfSnapGoogleAdSense\View\Helper\Renderer\RendererInterface');
        $renderer->expects($this->any())
                ->method('render')
                ->will($this->returnValue('custom'));

        $ga = $this->ga;
        $this->assertEquals('custom', $ga('simplest', $renderer));
    }

    public function testRendererGetsSimpleAd()
    {
        $renderer = $this->getMock('\ZfSnapGoogleAdSense\View\Helper\Renderer\RendererInterface');
        $renderer->expects($this->any())
                ->method('render')
                ->will($this->returnArgument(0));

        $ga = $this->ga;
        /* @var $adUnit \ZfSnapGoogleAdSense\Model\AdUnit */
        $adUnit = $ga('simplest', $renderer);

        $this->assertInstanceOf('\ZfSnapGoogleAdSense\Model\AdUnit', $adUnit);
        $this->assertEquals('simplest', $adUnit->getName());
        $this->assertEquals(320, $adUnit->getWidth());
        $this->assertEquals(100, $adUnit->getHeight());
        $this->assertEquals($this->publisherId, $adUnit->getPublisherId());
        $this->assertEquals(12334234, $adUnit->getId());
        $this->assertEquals(AdUnit::TYPE_CONTENT, $adUnit->getType());
        $this->assertTrue($adUnit->isType(AdUnit::TYPE_CONTENT));
    }

    public function testRendererGetsCustomAds()
    {
        $renderer = $this->getMock('\ZfSnapGoogleAdSense\View\Helper\Renderer\RendererInterface');
        $renderer->expects($this->any())
                ->method('render')
                ->will($this->returnArgument(0));

        $ga = $this->ga;
        /* @var $adUnit \ZfSnapGoogleAdSense\Model\AdUnit */
        $adUnit = $ga('second', $renderer);

        $this->assertInstanceOf('\ZfSnapGoogleAdSense\Model\AdUnit', $adUnit);
        $this->assertEquals('custom name', $adUnit->getName());
        $this->assertEquals(200, $adUnit->getWidth());
        $this->assertEquals(300, $adUnit->getHeight());
        $this->assertEquals($this->publisherId, $adUnit->getPublisherId());
        $this->assertEquals(987654321, $adUnit->getId());
        $this->assertEquals(AdUnit::TYPE_LINK, $adUnit->getType());
        $this->assertTrue($adUnit->isType(AdUnit::TYPE_LINK));
    }

    public function testIsDisplayed()
    {
        $ga = $this->ga;

        $this->assertEquals(0, $ga->getUnitDisplayed(AdUnit::TYPE_CONTENT));

        $ga('simplest');
        $this->assertEquals(1, $ga->getUnitDisplayed(AdUnit::TYPE_CONTENT));

        $ga('simplest');
        $ga('simplest');
        $this->assertEquals(3, $ga->getUnitDisplayed(AdUnit::TYPE_CONTENT));
    }

    public function testDisplayedLimit()
    {
        $ga = $this->ga;

        $ga->setUnitLimit(AdUnit::TYPE_CONTENT, 2);

        $ga('simplest');
        $ga('simplest');

        $this->assertEquals(2, $ga->getUnitDisplayed(AdUnit::TYPE_CONTENT));

        $this->setExpectedException('ZfSnapGoogleAdSense\Exception', 'Exceeded content unit limit (2)');

        $ga('simplest');
    }

    public function testDisplayedLimitTwoTypes()
    {
        $ga = $this->ga;

        $ga->setUnitLimit(AdUnit::TYPE_CONTENT, 2);
        $ga->setUnitLimit(AdUnit::TYPE_LINK, 1);

        $ga('simplest');
        $ga('linktype');
        $ga('simplest');

        $this->assertEquals(2, $ga->getUnitDisplayed(AdUnit::TYPE_CONTENT));
        $this->assertEquals(1, $ga->getUnitDisplayed(AdUnit::TYPE_LINK));

        $this->setExpectedException('ZfSnapGoogleAdSense\Exception', 'Exceeded link unit limit (1)');

        $ga('linktype');
    }

    public function testRenderNotExistsAd()
    {
        $ga = $this->ga;

        $this->setExpectedException('ZfSnapGoogleAdSense\Exception', 'Ad unit "foo" does not exist');

        $ga('foo');
    }
}
