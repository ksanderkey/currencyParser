<?php

namespace App;

use App\Viewer\ViewerInterface;

/**
 * Application
 */
class App
{
    /**
     * @var ViewerInterface
     */
    protected $viewer;

    /**
     * App constructor.
     *
     * @param ViewerInterface $viewer
     */
    public function __construct(ViewerInterface $viewer)
    {
        $this->viewer = $viewer;
    }

    /**
     * Start app
     */
    public function run()
    {
        $template = __DIR__ . DIRECTORY_SEPARATOR . "Resources/views/base.html.php";

        echo $this->viewer->render($template, ['testVar' => "Jack"]);
    }
}