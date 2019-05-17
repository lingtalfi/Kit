<?php


namespace Ling\Kit\PageRenderer;


/**
 * The KitPageRendererAwareInterface interface.
 */
interface KitPageRendererAwareInterface
{

    /**
     * Sets the KitPageRenderer instance.
     *
     *
     * @param KitPageRenderer $renderer
     * @return void
     */
    public function setKitPageRenderer(KitPageRenderer $renderer);
}