<?php

namespace TopCat\Entities;

class CatEntity
{
    private $id;
    private $image;
    private $breed;

    public function __construct(int $id = 0, string $image = '', int $breed = 0) {
        $this->id = $id;
        $this->image = $image;
        $this->breed = $breed;
    }

    public function getID() {
        return $this->id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getBreed() {
        return $this->breed;
    }
}