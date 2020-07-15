<?php

namespace VentureLeapUtilBundle\Services\Health;

use VentureLeapUtilBundle\Model\Health\HealthCheck;
use VentureLeapUtilBundle\Model\Health\HealthCheckStatusTypes;

class HealthCheckProvider implements HealthCheckProviderInterface
{
    public const STATUS_KEY = 'status';
    public const CHECKS_KEY = 'checks';
    public const MAIN_CHECK_NAME = 'main';

    /**
     * @var array
     */
    private $healthCheckers;

    public function __construct(GitHealthCheckProvider $gitHealthCheckProvider, DBHealthCheckProvider $dbHealthCheckProvider)
    {
        $this->healthCheckers = [
            $gitHealthCheckProvider,
            $dbHealthCheckProvider
        ];
    }

    public function getHealthCheck(): HealthCheck
    {
        $mainHealthCheck = new HealthCheck();
        $mainHealthCheck->setKey(static::MAIN_CHECK_NAME);
        $healthChecks = $this->getHealthChecks();

        /** @var HealthCheck $healthCheck */
        foreach ($healthChecks as $healthCheck) {
            $mainHealthCheck->addValue(
                $healthCheck->getKey(),
                [
                    static::STATUS_KEY => $healthCheck->getStatus(),
                    static::CHECKS_KEY => $healthCheck->getValues(),
                ]
            );
        }

        $mainHealthCheck->setStatus($this->getOverallStatusForHealthChecks($healthChecks));

        return $mainHealthCheck;
    }

    public function getHealthCheckAsArray(): array
    {
        $healthCheck = $this->getHealthCheck();

        return [
            $healthCheck->getKey(),
            [
                static::STATUS_KEY => $healthCheck->getStatus(),
                static::CHECKS_KEY => $healthCheck->getValues(),
            ],
        ];
    }

    private function getHealthChecks(): array
    {
        $healthChecks = [];

        /** @var HealthCheckProviderInterface $healthChecker */
        foreach ($this->healthCheckers as $healthChecker) {
            $healthChecks[] = $healthChecker->getHealthCheck();
        }

        return $healthChecks;
    }

    public function registerHealthCheckProvider(HealthCheckProviderInterface $healthChecker): void
    {
        $this->healthCheckers[] = $healthChecker;
    }

    private function getOverallStatusForHealthChecks(array $healthChecks): string
    {
        $overallStatus = HealthCheckStatusTypes::OK;

        $statusArray = array_map(
            function (HealthCheck $healthCheck) {
                return $healthCheck->getStatus();
            },
            $healthChecks
        );

        if (in_array(HealthCheckStatusTypes::ERROR, $statusArray, true)) {
            $overallStatus = HealthCheckStatusTypes::ERROR;
        } elseif (in_array(HealthCheckStatusTypes::WARNING, $statusArray, true)) {
            $overallStatus = HealthCheckStatusTypes::WARNING;
        }

        return $overallStatus;
    }
}
