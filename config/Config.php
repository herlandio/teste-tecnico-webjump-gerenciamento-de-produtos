<?php


namespace Config;


abstract class Config {

    /**###################################################################################
     *
     * Database
     *
     * DBHOST :: Host database
     * DBUSER :: User database
     * DBPASSWORD :: Password database
     * DBDATABASE :: Name database
     * DBPORT :: Port database
     *
     * #################################################################################*/

    const DBHOST = "localhost";
    const DBUSER = "root";
    const DBPASSWORD = "";
    const DBDATABASE = "products";
    const DBPORT = "3306";

}