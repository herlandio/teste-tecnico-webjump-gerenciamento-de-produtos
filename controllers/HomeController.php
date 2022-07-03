<?php

namespace Controllers;


use Help\BaseView;

class HomeController {

    /**
     * Define the view
     */
    public function Home() {

        $baseView = new BaseView();

        /**
         * Set title for page
         */
        $baseView->setTitle('Lista de Produtos');

        /**
         * Set folder of view
         */
        $baseView->Folder('Home/');
    }

}
