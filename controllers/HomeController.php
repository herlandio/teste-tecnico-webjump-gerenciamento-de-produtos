<?php

declare(strict_types=1);

namespace Controllers;

use Help\BaseView;

/**
 * Class HomeController
 *
 * Controller responsible for the home page of the application.
 */
class HomeController {

    /**
     * Renders the view for the home page.
     * Sets the page title and the view folder to be displayed.
     *
     * @return void
     */
    public function home(): void {
        $baseView = new BaseView();
        $baseView->setTitle('Product List');
        $baseView->folder('Home/');
    }

}

