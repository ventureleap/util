<?php

namespace VentureLeapUtilBundle\Services\Health;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use VentureLeapUtilBundle\Entity\Asset;
use VentureLeapUtilBundle\Model\Health\HealthCheck;
use VentureLeapUtilBundle\Model\Health\HealthCheckStatusTypes;

class DBHealthCheckProvider implements HealthCheckProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return HealthCheck
     */
    public function getHealthCheck(): HealthCheck
    {
        $healthCheck = new HealthCheck();
        $healthCheck->setStatus(HealthCheckStatusTypes::OK);
        $healthCheck->setKey('db');

        try {
            $this->entityManager->getRepository(Customer::class)->findBy(['id' => 1]);
            $healthCheck->addValue('connection', HealthCheckStatusTypes::OK);
        } catch (\Exception $exception) {
            $healthCheck->setStatus(HealthCheckStatusTypes::ERROR);
            $healthCheck->addValue('connection', HealthCheckStatusTypes::ERROR);
        }

        return $healthCheck;
    }
}
