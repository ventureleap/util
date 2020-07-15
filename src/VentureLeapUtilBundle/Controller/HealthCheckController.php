<?php

namespace VentureLeapUtilBundle\Controller;

use VentureLeapUtilBundle\Model\Health\HealthCheck;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use VentureLeapUtilBundle\Services\Health\HealthCheckProvider;

class HealthCheckController extends Controller
{
    /**
     * @Route("/_health", name="venture_leap_util_health_check")
     *
     * @param HealthCheckProvider $healthCheckProvider
     * @return JsonResponse
     */
    public function healthCheckAction(HealthCheckProvider $healthCheckProvider): JsonResponse
    {
        /** @var HealthCheck $results */
        $results = $healthCheckProvider->getHealthCheck();

        return new JsonResponse(
            $results->toArray(),
            ($results->hasFailed()) ? Response::HTTP_SERVICE_UNAVAILABLE : Response::HTTP_OK
        );
    }
}
