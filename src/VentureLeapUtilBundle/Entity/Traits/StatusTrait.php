<?php

namespace VentureLeapUtilBundle\Entity\Traits;

use App\Model\Content\ContentStatus;
use App\Model\Content\ContentValidationGroups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait StatusTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     *
     * @Assert\EqualTo(
     *      value=ContentStatus::STATUS_DRAFT,
     *      groups={ContentValidationGroups::VALIDATION_GROUP_SUMMARY},
     *      message="text.contentWizard.alreadySubmitted"
     * )
     */
    protected $status;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
