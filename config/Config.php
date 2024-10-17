<?php

declare(strict_types=1);

namespace Config;

use RenokiCo\PhpK8s\KubernetesCluster;
use RenokiCo\PhpK8s\Exceptions\KubernetesException;

/* The `abstract class Config` is defining a base class named `Config` that cannot be instantiated on
its own but can be extended by other classes. This class serves as a blueprint for other classes to
inherit common properties and methods. In this specific case, the `Config` class contains static
methods for retrieving configuration values related to a MySQL database connection. */
abstract class Config {

    private static array $secret = [];

    public static function initialize(): void {
        $kubeConfigPath = __DIR__ . '/../k8s/db-config.yaml';

        if (!file_exists($kubeConfigPath)) {
            throw new \RuntimeException('Kube config file not found at: ' . $kubeConfigPath);
        }

        $kubeConfigContent = file_get_contents($kubeConfigPath);
        if ($kubeConfigContent === false) {
            throw new \RuntimeException('Failed to read kube config file.');
        }

        try {
            $cluster = KubernetesCluster::fromKubeConfigVariable($kubeConfigContent);
            $client = $cluster->client();

            $secret = $client->secrets()->inNamespace('default')->get('db-secret');
            self::$secret = $secret->getData();

            if (empty(self::$secret)) {
                throw new \RuntimeException('Failed to retrieve Kubernetes secret data.');
            }
        } catch (KubernetesException $e) {
            throw new \RuntimeException('Failed to connect to Kubernetes: ' . $e->getMessage());
        }
    }

    /**
     * The function `getHost` returns the value of the environment variable `MYSQL_DB_HOST` as a
     * string.
     *
     * @return string The `MYSQL_DB_HOST` environment variable value is being returned as a string by
     * the `getHost` function.
     */
    public static function getHost(): string {
        return getenv('MYSQL_DB_HOST') ?: base64_decode(self::$secret['MYSQL_DB_HOST']);
    }

    /**
     * The function `getUser` returns the value of the environment variable `MYSQL_DB_USER` as a
     * string.
     *
     * @return string The function `getUser()` is returning the value of the environment variable
     * `MYSQL_DB_USER`.
     */
    public static function getUser(): string {
        return getenv('MYSQL_DB_USER') ?: base64_decode(self::$secret['MYSQL_DB_USER']);
    }

    /**
     * The function `getPassword` returns the MySQL root password stored in the environment variable
     * `MYSQL_ROOT_PASSWORD`.
     *
     * @return string The `MYSQL_ROOT_PASSWORD` environment variable is being returned as a string.
     */
    public static function getPassword(): string {
        return getenv('MYSQL_ROOT_PASSWORD') ?: base64_decode(self::$secret['MYSQL_ROOT_PASSWORD']);
    }

    /**
     * The function `getDatabase` returns the value of the environment variable `MYSQL_DATABASE` as a
     * string in PHP.
     *
     * @return string The function `getDatabase()` is returning the value of the environment variable
     * `MYSQL_DATABASE`.
     */
    public static function getDatabase(): string {
        return getenv('MYSQL_DATABASE') ?: base64_decode(self::$secret['MYSQL_DATABASE']);
    }

    /**
     * The function `getPort` returns the MySQL database port from the environment variable
     * `MYSQL_DB_PORT` as a string.
     *
     * @return string The `getPort` function is returning the value of the environment variable
     * `MYSQL_DB_PORT` as a string.
     */
    public static function getPort(): string {
        return getenv('MYSQL_DB_PORT') ?: base64_decode(self::$secret['MYSQL_DB_PORT']);
    }

}
