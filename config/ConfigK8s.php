<?php

declare(strict_types=1);

namespace Config;

use App\Exceptions\KeyK8sNotFoundException;
use Symfony\Component\Yaml\Yaml;
use RenokiCo\PhpK8s\KubernetesCluster;
use RuntimeException;

abstract class ConfigK8s {

    public const KUBE_CONFIG_PATH = 'KUBE_CONFIG_PATH';
    public const SECRET_NAME = 'db-secret';
    public const NAMESPACE = 'default';

    /**
     * Configure client k8s
     *
     * @return KubernetesCluster
     */
    private static function getK8sClient(): KubernetesCluster {
        $kubeConfigPath = getenv(self::KUBE_CONFIG_PATH);
        $kubeConfig = Yaml::parseFile($kubeConfigPath);
        return KubernetesCluster::fromKubeConfigArray($kubeConfig);
    }

    /**
     * The function `getSecretValue` find value secret Kubernetes.
     *
     * @param string $key Secret key.
     * @return string Value key.
     * @throws RuntimeException If not found key.
     */
    public static function getSecretValue(string $key): string {
        $client = self::getK8sClient();
        
        $secret = $client->secret()->getByName(self::SECRET_NAME, [self::NAMESPACE]);

        if ($secret && $secret->hasData($key)) {
            return base64_decode($secret->getData()[$key]);
        }

        throw new KeyK8sNotFoundException($key);
    }
}
