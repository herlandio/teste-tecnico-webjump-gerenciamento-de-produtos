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

    const DBHOST = "mysql";
    const DBUSER = "root";
    const DBPASSWORD = "root";
    const DBDATABASE = "products";
    const DBPORT = "3306";

}