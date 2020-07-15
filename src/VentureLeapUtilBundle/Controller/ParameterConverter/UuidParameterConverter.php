<?php

namespace VentureLeapUtilBundle\Controller\ParameterConverter;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use VentureLeapUtilBundle\Entity\Traits\UuidTrait;

class UuidParameterConverter implements ParamConverterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $uuid = $request->get($configuration->getName());
        if ($uuid) {
            $entity = $this
                ->entityManager->getRepository($configuration->getClass())
                ->findOneBy(['uuid' => $request->get($configuration->getName())]);

            if ($entity) {
                $request->attributes->set($configuration->getName(), $entity);
            }
        }
    }

    public function supports(ParamConverter $configuration): bool
    {
        $hasUuidTrait = false;

        if ($configuration->getClass()) {
            if (in_array(UuidTrait::class, class_uses($configuration->getClass()), true)) {
                $hasUuidTrait = true;
            } else {
                foreach (class_parents($configuration->getClass()) as $parent) {
                    if (in_array(UuidTrait::class, class_uses($parent), true)) {
                        $hasUuidTrait = true;
                    }
                }
            }
        }

        return $hasUuidTrait;
    }
}
