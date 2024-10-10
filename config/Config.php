<?php

declare(strict_types=1);

namespace Config;

/* The `abstract class Config` is defining a base class named `Config` that cannot be instantiated on
its own but can be extended by other classes. This class serves as a blueprint for other classes to
inherit common properties and methods. In this specific case, the `Config` class contains static
methods for retrieving configuration values related to a MySQL database connection. */
abstract class Config {

    /**
     * The function `getHost` returns the value of the environment variable `MYSQL_DB_HOST` as an
     * array, boolean, or string.
     *
     * @return array|bool|string The `getHost()` function is returning the value of the environment
     * variable `MYSQL_DB_HOST`. The return type of the function is specified as `array|bool|string`,
     * indicating that the return value could be an array, a boolean, or a string.
     */
    public static function getHost(): array|bool|string {
        return getenv('MYSQL_DB_HOST');
    }

    /**
     * The function returns the value of the environment variable MYSQL_DB_USER as an array, boolean,
     * or string.
     *
     * @return array|bool|string the value of the environment variable 'MYSQL_DB_USER'. It can return
     * an array, boolean, or string depending on the value of the environment variable.
     */
    public static function getUser(): array|bool|string {
        return getenv('MYSQL_DB_USER');
    }

    /**
     * The function `getPassword` returns the MySQL root password stored in the environment variable or
     * a boolean or string value.
     *
     * @return array|bool|string The `getPassword()` function is returning the value of the environment
     * variable `MYSQL_ROOT_PASSWORD`. This value can be of type array, boolean, or string depending on
     * what is stored in the environment variable.
     */
    public static function getPassword(): array|bool|string {
        return getenv('MYSQL_ROOT_PASSWORD');
    }

    /**
     * The function `getDatabase` returns the value of the environment variable `MYSQL_DATABASE` as an
     * array, boolean, or string.
     *
     * @return array|bool|string The function `getDatabase()` is returning the value of the environment
     * variable `MYSQL_DATABASE`. The return type of the function is either an array, a boolean, or a
     * string, depending on the value of the environment variable.
     */
    public static function getDatabase(): array|bool|string {
        return getenv('MYSQL_DATABASE');
    }

    /**
     * The function `getPort` returns the value of the environment variable `MYSQL_DB_PORT` as an
     * array, boolean, or string.
     *
     * @return array|bool|string The `getPort()` function is returning the value of the environment
     * variable `MYSQL_DB_PORT`. The return type of the function is specified as an array, boolean, or
     * string.
     */
    public static function getPort(): array|bool|string {
        return getenv('MYSQL_DB_PORT');
    }

}

