<?php

namespace App\Viewer;

/**
 * Class Viewer
 */
class Viewer implements ViewerInterface
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $parameters;

    /**
     * {@inheritdoc}
     */
    public function render($template, array $parameters = array())
    {
        $this->template = $template;
        $this->parameters = $parameters;
        extract($this->parameters, EXTR_SKIP);
        $this->parameters = null;
        ob_start();
        require $this->template;
        $this->template = null;

        return ob_get_clean();
    }
}