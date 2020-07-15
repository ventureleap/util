<?php

namespace VentureLeapUtilBundle\Entity\Interfaces;

interface AssetInterface
{
    public function getFilename(): string;

    public function getRelativeUrl(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    public function getType(): string;

    public function getFileType(): string;

    public function getOriginalFilename(): string;

    public function getStorageType(): string;
}
