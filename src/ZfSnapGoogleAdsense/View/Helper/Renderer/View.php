<?php

namespace ZfSnapGoogleAdsense\View\Helper\Renderer;

use ZfSnapGoogleAdsense\AdUnit;
use Zend\View\Renderer\PhpRenderer;

/**
 * View renderer
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class View implements RendererInterface
{
    protected $params;
    protected $renderer;
    protected $template;
    protected $partial;

    public function __construct(PhpRenderer $renderer, $template, array $params = array())
    {
        $this->params = $params;
        $this->renderer = $renderer;
        $this->template = $template;
    }

    public function render(AdUnit $ad)
    {
        $partial = $this->getPartial();

        return $partial($this->template, array(
            'ad' => $ad,
            'params' => $this->params,
        ));
    }

    protected function getPartial()
    {
        if ($this->partial === null) {
            $this->partial = $this->renderer->plugin('partial');
        }
        return $this->partial;
    }

}
