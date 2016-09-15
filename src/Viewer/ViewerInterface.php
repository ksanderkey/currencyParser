<?php

namespace CliCrawler\Viewer;

/**
 * Interface ViewerInterface
 */
interface ViewerInterface
{
    /**
     * Renders a template.
     *
     * @param string $template
     * @param array  $parameters
     *
     * @return mixed
     */
    public function render($template, array $parameters = array());
}