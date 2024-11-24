<?php

error_reporting(-1);
ini_set('display_errors', 1);

//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
//use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
//use Slim\Routing\RouteContext;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/controller/TiendaController.php';
require_once __DIR__ . '/controller/VentaController.php';
require_once __DIR__ . '/middleware/InputMiddleware.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$app->addBodyParsingMiddleware();

$app->group('/tienda', function (RouteCollectorProxy $group) {
    $group->post('/alta', \TiendaController::class . ':alta')->add(new AltaProdInputMiddleware());
	$group->post('/consultar', \TiendaController::class . ':traerTodos');
});


$app->group('/ventas/consultar', function (RouteCollectorProxy $group) {
    $group->get('/ventas/porUsuario', \VentaController::class . ':traerVentasPorUsuario');
    $group->get('/ventas/porProducto', \VentaController::class . ':traerVentasPorProducto');
    $group->get('/ventas/ingresos', \VentaController::class . ':traerVentasPorIngresos');
    $group->get('/productos/vendidos', \VentaController::class . ':traerProductosPorFecha');
    $group->get('/productos/entreValores', \VentaController::class . ':traerProductoEntreValores');
    $group->get('/productos/masVendido', \VentaController::class . ':traerProductoMasVendido');
});

$app->post('/ventas/alta', \VentaController::class . ':alta');

$app->put('/ventas/modificar', \VentaController::class . ':actualizar');

$app->get('/health-check', function ($request, $response, array $args) {
		$response->getBody()->write("Ok!");
return $response;
});


$app->run();
?>