<?php

namespace RPGBundle\Service;

use InvalidArgumentException;

class MapService
{
   public function generateMap(int $level): array
   {
       if ($level < 1) {
           throw new InvalidArgumentException();
       }

       $map = [];
       for($i = 0; $i < $level; $i++) {
           $row = [];
           for($j = 0; $j < $level; $j++) {
                $row[] = rand(1, $level);
           }
           $map[] = $row;
       }

        return $map;
   }
}
