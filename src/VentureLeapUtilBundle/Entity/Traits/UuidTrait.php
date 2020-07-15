<?php

namespace VentureLeapUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * To be used in links without exposing the id.
 * Don't forget to create an index in the specific entity.
 */
trait UuidTrait
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="string", unique=true, length=36)
     */
    protected $uuid;

    public function __toString(): string
    {
        return $this->uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
