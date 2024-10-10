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

     public static function getDbHost() {
        return getenv('MYSQL_DB_HOST');
    }

    public static function getDbUser() {
        return getenv('MYSQL_DB_USER');
    }

    public static function getDbPassword() {
        return getenv('MYSQL_ROOT_PASSWORD');
    }

    public static function getDbDatabase() {
        return getenv('MYSQL_DATABASE');
    }

    public static function getDbPort() {
        return getenv('MYSQL_DB_PORT');
    }

}
