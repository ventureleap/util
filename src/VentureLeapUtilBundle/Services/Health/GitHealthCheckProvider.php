<?php

namespace VentureLeapUtilBundle\Services\Health;

use VentureLeapUtilBundle\Model\Health\HealthCheck;
use VentureLeapUtilBundle\Model\Health\HealthCheckStatusTypes;

class GitHealthCheckProvider implements HealthCheckProviderInterface
{
    public function getHealthCheck(): HealthCheck
    {
        $commitCode = trim(exec('git log --pretty="%h" -n1 HEAD'));
        $healthCheck = new HealthCheck();
        $healthCheck->setKey('git');
        $healthCheck->setStatus($commitCode ? HealthCheckStatusTypes::OK : HealthCheckStatusTypes::ERROR);
        $healthCheck->addValue('commit', $commitCode);

        return $healthCheck;
    }
}
