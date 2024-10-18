<?php

declare(strict_types=1);

namespace Config;

use Symfony\Component\Yaml\Yaml;
use RenokiCo\PhpK8s\KubernetesCluster;
use RuntimeException;

/* The `abstract class Config` is defining a base class named `Config` that cannot be instantiated on
its own but can be extended by other classes. This class serves as a blueprint for other classes to
inherit common properties and methods. In this specific case, the `Config` class contains static
methods for retrieving configuration values related to a MySQL database connection. */
abstract class Config {

    /**
     * Configure client k8s
     *
     * @return KubernetesCluster
     */
    private static function getK8sClient(): KubernetesCluster {
        $kubeConfig = Yaml::parseFile('/root/.kube/config');
        return KubernetesCluster::fromKubeConfigArray($kubeConfig);
    }

    /**
     * The function `getSecretValue` find value secret Kubernetes.
     *
     * @param string $key Secret key.
     * @return string Value key.
     * @throws RuntimeException If not found key.
     */
    private static function getSecretValue(string $key): string {
        $client = self::getK8sClient();
        
        $secret = $client->secret()->getByName('db-secret', ['default']);

        if ($secret && $secret->hasData($key)) {
            return base64_decode($secret->getData()[$key]);
        }

        throw new RuntimeException("Error get key for: $key");
    }

    /**
     * The function `getHost` returns the value of the environment variable `MYSQL_DB_HOST` as a
     * string, or retrieves it from the secret if not set.
     *
     * @return string The `MYSQL_DB_HOST` environment variable value or the secret value.
     */
    public static function getHost(): string {
        return getenv('MYSQL_DB_HOST') ?: self::getSecretValue('MYSQL_DB_HOST');
    }

    /**
     * The function `getUser` returns the value of the environment variable `MYSQL_DB_USER` as a
     * string, or retrieves it from the secret if not set.
     *
     * @return string The function `getUser()` is returning the value of the environment variable
     * `MYSQL_DB_USER` or the secret value.
     */
    public static function getUser(): string {
        return getenv('MYSQL_DB_USER') ?: self::getSecretValue('MYSQL_DB_USER');
    }

    /**
     * The function `getPassword` returns the MySQL root password stored in the environment variable
     * `MYSQL_ROOT_PASSWORD`, or retrieves it from the secret if not set.
     *
     * @return string The `MYSQL_ROOT_PASSWORD` environment variable value or the secret value.
     */
    public static function getPassword(): string {
        return getenv('MYSQL_ROOT_PASSWORD') ?: self::getSecretValue('MYSQL_ROOT_PASSWORD');
    }

    /**
     * The function `getDatabase` returns the value of the environment variable `MYSQL_DATABASE` as a
     * string, or retrieves it from the secret if not set.
     *
     * @return string The function `getDatabase()` is returning the value of the environment variable
     * `MYSQL_DATABASE` or the secret value.
     */
    public static function getDatabase(): string {
        return getenv('MYSQL_DATABASE') ?: self::getSecretValue('MYSQL_DATABASE');
    }

    /**
     * The function `getPort` returns the MySQL database port from the environment variable
     * `MYSQL_DB_PORT` as a string, or retrieves it from the secret if not set.
     *
     * @return string The `getPort` function is returning the value of the environment variable
     * `MYSQL_DB_PORT` or the secret value.
     */
    public static function getPort(): string {
        return getenv('MYSQL_DB_PORT') ?: self::getSecretValue('MYSQL_DB_PORT');
    }

}
