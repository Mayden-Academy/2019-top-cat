<?php

namespace hydrators;

class CatHydrator
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function createCatEntities(string $breedID): array
    {
        $sqlCommand = 'SELECT `id`, `img_src`, `breed_id` FROM `img` WHERE `breed_id` = ' . $breedID;
        $this->db->prepare($sqlCommand);
        $this->db->execute();

        $cats = $this->db->fetchAll();
        return $cats;
    }
}