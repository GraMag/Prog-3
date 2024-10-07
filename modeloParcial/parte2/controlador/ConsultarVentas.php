<?php

class ConsultarVentas{

    public static function consultarVentasEnFecha($get){
        $heladosVendidosFecha = Venta::buscarVentasPorFecha($get);
       
        if($heladosVendidosFecha == 0){
            http_response_code(404);
            echo json_encode("No hay resultados");
        } else {
            http_response_code(200);
            echo json_encode($heladosVendidosFecha);
        }
    }

    public static function consultarVentasPorUsuario($get){
    }

    public static function consultarVentasEntreFechas($get){
    }

    public static function consultarVentasPorSabor($get){
    }

    public static function consultarVentasPorCucurucho($get){
    }
}