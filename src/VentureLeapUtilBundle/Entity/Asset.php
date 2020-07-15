<?php

namespace VentureLeapUtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use VentureLeapUtilBundle\Entity\Interfaces\AssetInterface;
use VentureLeapUtilBundle\Entity\Traits\ActiveTrait;
use VentureLeapUtilBundle\Entity\Traits\IdTrait;
use VentureLeapUtilBundle\Entity\Traits\TimestampableTrait;
use VentureLeapUtilBundle\Model\Asset\AssetStorageTypes;
use VentureLeapUtilBundle\Model\Asset\AssetTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * The Class to store all information about uploaded assets. If during upload, the assets are processed,
 * the respective assets will be available as childAssets.
 *
 * @ORM\Entity(repositoryClass="VentureLeapUtilBundle\Entity\Repository\AssetRepository")
 * @ORM\Table(name="venture_leap_asset")
 * @ORM\HasLifecycleCallbacks()
 */
class Asset implements Translatable, AssetInterface
{
    use IdTrait;
    use TimestampableTrait;
    use ActiveTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="file_type", type="string", length=50, nullable=true)
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=200, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $filename;

    /**
     * The relative path.
     *
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=200, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="original_file_name", type="string", length=200, nullable=true)
     *
     * @Exclude()
     */
    private $originalFileName;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     *
     * @Exclude()
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     *
     * @Gedmo\Translatable()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $type;

    /**
     * The name of the type, if it is a processed asset.
     *
     * @var string
     *
     * @ORM\Column(name="processed_type", type="string", length=50, nullable=true)
     *
     * @Groups({"asset_list", "asset_details"})
     */
    private $processedType;

    /**
     * @var string
     *
     * @ORM\Column(name="storage_type", type="string", length=10, nullable=true)
     *
     * @Exclude()
     */
    private $storageType;

    /**
     * @var bool
     *
     * @ORM\Column(name="processing_failed", type="boolean", nullable=true)
     *
     * @Exclude()
     */
    private $processingFailed;

    /**
     * @var string
     *
     * @ORM\Column(name="processing_failed_formats", type="string", length=500, nullable=true)
     *
     * @Exclude()
     */
    private $processingFailedFormats;

    /**
     * @var Asset
     *
     * @ORM\ManyToOne(targetEntity="VentureLeapUtilBundle\Entity\Asset", inversedBy="childAssets")
     *
     * @Exclude()
     */
    private $parentAsset;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="VentureLeapUtilBundle\Entity\Asset", mappedBy="parentAsset", cascade={"all"})
     *
     * @Groups({"asset_children"})
     */
    private $childAssets;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @var string
     */
    private $fileContents;

    /**
     * @var bool
     */
    private $skipProcessing;

    public function __construct()
    {
        $this->childAssets = new ArrayCollection();
        $this->storageType = AssetStorageTypes::PUBLIC_STORAGE;
        $this->processingFailedFormats = '';
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }

    public function getOriginalFileName(): string
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName(string $originalFileName): void
    {
        $this->originalFileName = $originalFileName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getRelativeUrl(): string
    {
        return $this->path.$this->filename;
    }

    public function getChildAssetByType(string $type): ?Asset
    {
        $foundChildAsset = $this;

        /** @var Asset $childAsset */
        foreach ($this->childAssets as $childAsset) {
            if ($childAsset->getType() === $type) {
                $foundChildAsset = $childAsset;
                break;
            }
        }

        return $foundChildAsset;
    }

    public function getRelativeUrlForChildAssetType(string $type): ?string
    {
        $foundChildAsset = $this->getChildAssetByType($type);

        return $foundChildAsset ? $foundChildAsset->getRelativeUrl() : null;
    }

    public function getChildAssets(): Collection
    {
        return $this->childAssets;
    }

    public function setChildAssets(Collection $childAssets): void
    {
        $this->childAssets = $childAssets;
    }

    public function addChildAsset(Asset $childAsset): void
    {
        $childAsset->setParentAsset($this);
        $this->childAssets->add($childAsset);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function isImage(): bool
    {
        return AssetTypes::IMAGE === $this->type
            || in_array(strtolower(pathinfo($this->originalFileName, PATHINFO_EXTENSION)), ['jpg', 'png', 'gif', 'jpeg', 'bmp', 'tif']);
    }

    public function isPdf(): bool
    {
        return AssetTypes::PDF === $this->type
            || in_array(strtolower(pathinfo($this->originalFileName, PATHINFO_EXTENSION)), ['pdf']);
    }

    public function isEmpty(): bool
    {
        return empty($this->filename);
    }

    public function isNotEmpty(): bool
    {
        return false === $this->isEmpty();
    }

    public function getParentAsset(): ?Asset
    {
        return $this->parentAsset;
    }

    public function setParentAsset(Asset $parentAsset): void
    {
        $this->parentAsset = $parentAsset;
    }

    public function isChildAsset(): bool
    {
        return null !== $this->parentAsset;
    }

    public function getStorageType(): string
    {
        return $this->storageType;
    }

    public function setStorageType(string $storageType): void
    {
        $this->storageType = $storageType;
    }

    public function isPublicStorage(): bool
    {
        return AssetStorageTypes::PUBLIC_STORAGE === $this->storageType;
    }

    public function isSecureStorage(): bool
    {
        return AssetStorageTypes::SECURE_STORAGE === $this->storageType;
    }

    public function getProcessedType(): string
    {
        return $this->processedType;
    }

    public function setProcessedType(string $processedType): void
    {
        $this->processedType = $processedType;
    }

    public function getChildAssetByProcessedType(string $processedType): ?Asset
    {
        $processedImage = $this;

        /** @var Asset $childAsset */
        foreach ($this->childAssets as $childAsset) {
            if ($childAsset->getProcessedType() === $processedType) {
                $processedImage = $childAsset;
                break;
            }
        }

        return $processedImage;
    }

    public function getFileContents(): string
    {
        return $this->fileContents;
    }

    public function setFileContents(string $fileContents): void
    {
        $this->fileContents = $fileContents;
    }

    public function isSkipProcessing(): bool
    {
        return $this->skipProcessing;
    }

    public function setSkipProcessing(bool $skipProcessing): void
    {
        $this->skipProcessing = $skipProcessing;
    }

    public function getProcessingFailedFormats(): ?string
    {
        return $this->processingFailedFormats;
    }

    public function setProcessingFailedFormats(string $processingFailedFormats): void
    {
        $this->processingFailedFormats = $processingFailedFormats;
    }

    public function addProcessingFailedFormats(string $processingFailedFormats): void
    {
        $this->processingFailedFormats .= ' --- '.$processingFailedFormats;
    }

    public function isProcessingFailed(): ?bool
    {
        return $this->processingFailed;
    }

    public function setProcessingFailed(bool $processingFailed): void
    {
        $this->processingFailed = $processingFailed;
    }
}
