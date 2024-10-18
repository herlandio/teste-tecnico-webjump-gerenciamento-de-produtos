<?php

declare(strict_types=1);

namespace Config;

/* The `abstract class Config` is defining a base class named `Config` that cannot be instantiated on
its own but can be extended by other classes. This class serves as a blueprint for other classes to
inherit common properties and methods. In this specific case, the `Config` class contains static
methods for retrieving configuration values related to a MySQL database connection. */
abstract class Config {

    /**
     * The function `getHost` returns the value of the environment variable `MYSQL_DB_HOST` as a
     * string.
     *
     * @return string The `MYSQL_DB_HOST` environment variable value is being returned as a string by
     * the `getHost` function.
     */
    public static function getHost(): string {
        return getenv('MYSQL_DB_HOST');
    }

    /**
     * The function `getUser` returns the value of the environment variable `MYSQL_DB_USER` as a
     * string.
     *
     * @return string The function `getUser()` is returning the value of the environment variable
     * `MYSQL_DB_USER`.
     */
    public static function getUser(): string {
        return getenv('MYSQL_DB_USER');
    }

    /**
     * The function `getPassword` returns the MySQL root password stored in the environment variable
     * `MYSQL_ROOT_PASSWORD`.
     *
     * @return string The `MYSQL_ROOT_PASSWORD` environment variable is being returned as a string.
     */
    public static function getPassword(): string {
        return getenv('MYSQL_ROOT_PASSWORD');
    }

    /**
     * The function `getDatabase` returns the value of the environment variable `MYSQL_DATABASE` as a
     * string in PHP.
     *
     * @return string The function `getDatabase()` is returning the value of the environment variable
     * `MYSQL_DATABASE`.
     */
    public static function getDatabase(): string {
        return getenv('MYSQL_DATABASE');
    }

    /**
     * The function `getPort` returns the MySQL database port from the environment variable
     * `MYSQL_DB_PORT` as a string.
     *
     * @return string The `getPort` function is returning the value of the environment variable
     * `MYSQL_DB_PORT` as a string.
     */
    public static function getPort(): string {
        return getenv('MYSQL_DB_PORT');
    }

}
