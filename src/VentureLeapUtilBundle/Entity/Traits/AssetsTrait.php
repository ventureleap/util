<?php

namespace VentureLeapUtilBundle\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use VentureLeapUtilBundle\Entity\Asset;
use Doctrine\ORM\Mapping as ORM;
use VentureLeapUtilBundle\Model\Asset\AssetTypes;

trait AssetsTrait
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="VentureLeapUtilBundle\Entity\Asset", cascade={"all"})
     */
    protected $assets;

    public function getAssets(): Collection
    {
        $assetsAsArray = $this->assets->toArray();
        usort($assetsAsArray, function (Asset $a, Asset $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return new ArrayCollection($assetsAsArray);
    }

    public function setAssets(ArrayCollection $assets): void
    {
        $this->assets = $assets;
    }

    public function addAsset(Asset $asset): void
    {
        $this->assets->add($asset);
    }

    /**
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getImages(): array
    {
        return $this->getAssetsByType(AssetTypes::IMAGE);
    }

    /**
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getVideos(): array
    {
        return $this->getAssetsByType(AssetTypes::VIDEO);
    }

    /**
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getPdfs(): array
    {
        return $this->getAssetsByType(AssetTypes::PDF);
    }

    /**
     * @VirtualProperty()
     *
     * @Groups({"asset_list", "asset_details"})
     */
    public function getAudios(): array
    {
        return $this->getAssetsByType(AssetTypes::AUDIO);
    }

    protected function getAssetsByType(string $type): array
    {
        $assetsByType = $this->assets->filter(function (Asset $asset) use ($type) {
            return $asset->getType() === $type;
        })->toArray();

        usort($assetsByType, function (Asset $a, Asset $b) {
            return $a->getPriority() > $b->getPriority();
        });

        return $assetsByType;
    }
}
