<?php

class Helper {
    public static function generarId($lista) {
        $maxId = 0;

        $ultimoItem = end($lista);
        return ($ultimoItem != null) ? $ultimoItem->getId() + 1 : 1;
    }
}