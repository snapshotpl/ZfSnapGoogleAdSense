<?php

namespace ZfSnapGoogleAdsense\View\Helper\Renderer;
use ZfSnapGoogleAdsense\AdUnit;
/**
 *
 * @author witold
 */
interface RendererInterface {
    public function render(AdUnit $ad);
}
