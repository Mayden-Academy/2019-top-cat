<?php

namespace TopCat\Hydrators;

class CatHydrator
{
    private $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    /**
     * Creates an array of CatEntities of a particular breed.
     * 
     * @param int - Takes user input in the form of $breedID on page load following selection of breed from dropdown
     * @return array - Returns an array of Cat objects based on details acquired from database
     */
    public function createCatEntitiesArray(int $breedID): array {
        $sqlCommand = 'SELECT `id`, `img_src` AS `image`, `breed_id` AS `breed` FROM `img` WHERE `breed_id` =:breedID';
        $sqlStatement = $this->db->prepare($sqlCommand);
        $sqlStatement->bindParam('breedID', $breedID, \PDO::PARAM_INT);
        $sqlStatement->execute();
        $cats = $sqlStatement->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "TopCat\Entities\CatEntity");
        return $cats;
    }

    /**
     * @return array Returns a list of all of the cat breeds.
     */
    public function getBreeds(): array {
        $sqlStatement = $this->db->prepare('SELECT `breed`, `favourite_id` FROM `breed`;');
        $sqlStatement->execute();
        return $sqlStatement->fetchAll();
    }
}