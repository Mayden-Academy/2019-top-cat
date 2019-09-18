<?php

namespace TopCat\Hydrators;

use TopCat\Entities\CatEntity;

class CatHydrator
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function createCatEntitiesArray(int $breedID): array
    {
        $sqlCommand = 'SELECT `id`, `img_src` AS `image`, `breed_id` AS `breed` FROM `img` WHERE `breed_id` = ' . $breedID;
        $sqlStatement = $this->db->prepare($sqlCommand);
        $sqlStatement->execute();

        $cats = $sqlStatement->fetchAll(\PDO::FETCH_CLASS, "TopCat\Entities\CatEntity");
        return $cats;
    }

    // public function createCatEntitiesArray(array $cats): array
    // {
    //     $catEntities = [];
    //     $i = 1;

    //     foreach($cats as $cat) {
    //         $cat{$i} = new CatEntity($cat[0], $cat[1], $cat[2]);

    //         $i++;
    //     }

    //     return $catEntities
    // }
}