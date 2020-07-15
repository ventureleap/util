<?php

namespace VentureLeapUtilBundle\Services\Health;

use VentureLeapUtilBundle\Model\Health\HealthCheck;

interface HealthCheckProviderInterface
{
    public function getHealthCheck(): HealthCheck;
}
