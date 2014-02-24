<?php

namespace ZfSnapGoogleAdSense\View\Helper\Renderer;

use ZfSnapGoogleAdSense\Model\AdUnit;
use Zend\View\Renderer\PhpRenderer;

/**
 * View renderer
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class View implements RendererInterface
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     *
     * @var string
     */
    protected $template;

    /**
     * @var \Zend\View\Helper\Partial
     */
    protected $partial;

    /**
     * @param PhpRenderer $renderer
     * @param string $template
     * @param array $params
     */
    public function __construct(PhpRenderer $renderer, $template, array $params = array())
    {
        $this->params = $params;
        $this->renderer = $renderer;
        $this->template = $template;
    }

    /**
     * @param AdUnit $ad
     * @return string
     */
    public function render(AdUnit $ad)
    {
        $partial = $this->getPartial();

        return $partial($this->template, array(
            'ad' => $ad,
            'params' => $this->params,
        ));
    }

    /**
     * @return \Zend\View\Helper\Partial
     */
    protected function getPartial()
    {
        if ($this->partial === null) {
            $this->partial = $this->renderer->plugin('partial');
        }
        return $this->partial;
    }

}
