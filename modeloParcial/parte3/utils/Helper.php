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

    public static function generarIdPorPath($path) {
        $lista = Archivo::leer($path);
        return self::generarId($lista);
    }
}