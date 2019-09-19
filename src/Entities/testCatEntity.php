<?php

use PHPUnit\Framework\TestCase;
use TopCat\Entities\CatEntity;

class testCatEntity extends TestCase {
    public function testGetIDSuccess() {
        $expected = 3;
        $cat = new CatEntity(3, 'https://cdn2.thecatapi.com/images/xxxxx.jpg', 1);
        $actual = $cat->getID();
        $this->assertEquals($expected, $actual);
    }

    public function testGetImageSuccess() {
        $expected = 'https://cdn2.thecatapi.com/images/xxxxx.jpg';
        $cat = new CatEntity(396, 'https://cdn2.thecatapi.com/images/xxxxx.jpg', 43);
        $actual = $cat->getImage();
        $this->assertEquals($expected, $actual);
    }

    public function testGetBreedSuccess() {
        $expected = 5;
        $cat = new CatEntity(32, 'https://cdn2.thecatapi.com/images/xxxxx.jpg', 5);
        $actual = $cat->getBreed();
        $this->assertEquals($expected, $actual);
    }
}