<?php

namespace VentureLeapUtilBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use VentureLeapUtilBundle\Services\Depersonalize\Helper\EntityHelperInterface;

class VentureLeapUtilExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('venture_leap_util_sender_address', $config['email']['sender_address']);
        $container->setParameter('venture_leap_util_sender_name', $config['email']['sender_name']);

        $container->setParameter('venture_leap_util_s3_access_key_id', $config['aws']['s3_access_key_id']);
        $container->setParameter('venture_leap_util_s3_secret_access_key', $config['aws']['s3_secret_access_key']);

        $container->setParameter('venture_leap_util_s3_bucket', $config['aws']['s3_bucket']);

        $container->setParameter('venture_leap_util_cloudfront_public_endpoint', $config['aws']['cloudfront_public_endpoint']);
        $container->setParameter('venture_leap_util_cloudfront_secure_endpoint', $config['aws']['cloudfront_secure_endpoint']);

        $container->setParameter('venture_leap_util_cloudfront_private_key', $config['aws']['cloudfront_private_key']);
        $container->setParameter('venture_leap_util_cloudfront_private_key_pair_id', $config['aws']['cloudfront_private_key_pair_id']);

        $container->setParameter('venture_leap_util_asset_images', $config['asset']['images']);
        $container->setParameter('venture_leap_util_asset_pdf', $config['asset']['pdf']);
        $container->setParameter('venture_leap_util_asset_public_base_path', $config['asset']['public_base_path']);
        $container->setParameter('venture_leap_util_asset_secure_base_path', $config['asset']['secure_base_path']);
        $container->setParameter('venture_leap_util_asset_folder', $config['asset']['folder']);
    }
}
