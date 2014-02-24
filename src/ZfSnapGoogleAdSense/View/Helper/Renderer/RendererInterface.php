<?php

namespace ZfSnapGoogleAdSense\View\Helper\Renderer;

use ZfSnapGoogleAdSense\Model\AdUnit;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface RendererInterface
{
    public function render(AdUnit $ad);
}
