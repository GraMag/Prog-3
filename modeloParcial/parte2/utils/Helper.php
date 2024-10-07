<?php

class Helper {
    public static function generarId($lista) {
        $maxId = 0;

        foreach ($lista as $item) {
            if ($item->getId() > $maxId) {
                $maxId = $item->getId();
            }
        }

        return $maxId + 1;
    }
}