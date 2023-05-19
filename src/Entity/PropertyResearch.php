<?php

namespace App\Entity;

class PropertyResearch
{

    private $maxPrice;

    private $minSurface;

    /**
     * @return ?int
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int $maxPrice
     * @return PropertyResearch
     */
    public function setMaxPrice(int $maxPrice): PropertyResearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return ?int
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int $minSurface
     * @return PropertyResearch
     */
    public function setMinSurface(int $minSurface): PropertyResearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }









}