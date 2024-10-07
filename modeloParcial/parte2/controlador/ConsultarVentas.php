<?php

class ConsultarVentas{

    public static function consultarVentasEnFecha($get){
        try{
            $heladosVendidosFecha = Venta::buscarVentasPorFecha($get['fecha']);
        
            if(count($heladosVendidosFecha) == 0){
                http_response_code(404);
                echo json_encode("No hay resultados");
            } else {
                http_response_code(200);
                echo json_encode($heladosVendidosFecha);
            }
        } catch(Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
        }
    }

    public static function consultarVentasPorUsuario($get){
        try{
            $heladosVendidosUsuario = Venta::buscarVentasPorUsuario($get['email']);

            if(count($heladosVendidosUsuario) == 0){
                http_response_code(404);
                echo json_encode("No hay resultados");
            } else {
                http_response_code(200);
                echo json_encode($heladosVendidosUsuario);
            }
        } catch(Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
        }
    }

    public static function consultarVentasEntreFechas($get){
        try{
            $heladosVendidosUsuario = Venta::buscarVentaEntreFechas($get);

            if(count($heladosVendidosUsuario) == 0){
                http_response_code(404);
                echo json_encode("No hay resultados");
            } else {
                http_response_code(200);
                echo json_encode($heladosVendidosUsuario);
            }
        } catch(Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
        }
    }

    public static function consultarVentasPorSabor($get){
    }

    public static function consultarVentasPorCucurucho($get){
    }
}