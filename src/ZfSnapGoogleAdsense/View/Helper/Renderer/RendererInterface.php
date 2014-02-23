<?php

namespace ZfSnapGoogleAdsense\View\Helper\Renderer;

use ZfSnapGoogleAdsense\AdUnit;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface RendererInterface
{
    public function render(AdUnit $ad);
}
