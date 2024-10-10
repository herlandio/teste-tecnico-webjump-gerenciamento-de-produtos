<?php

declare(strict_types=1);

namespace Controllers;

use Help\BaseView;

class HomeController {

    /**
     * Define the view
     */
    public function home(): void {
        $baseView = new BaseView();
        $baseView->setTitle('Lista de Produtos');
        $baseView->Folder('Home/');
    }

}
