<?php

namespace VentureLeapUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DescriptionTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): void
    {
        $this->description = $description;
    }
}
