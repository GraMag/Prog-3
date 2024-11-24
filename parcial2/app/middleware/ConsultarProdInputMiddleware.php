<?php 

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../utils/Validador.php';

class ConsultarProdInputMiddleware{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $payload = '';
        $response = new \Slim\Psr7\Response();
        
        try{
            $parametros = $request->getParsedBody();
            
            $this->validarParametrosRequeridos($parametros);
            
            $this->validarLogicaNegocio($parametros);
            
            $response = $handler->handle($request);
        } catch (InvalidArgumentException $e) {
            $payload = json_encode(array("mensaje" => $e->getMessage()));
            $response = $response->withStatus(400);
        } catch (Exception $e) {
            $payload = json_encode(array("mensaje" => "Error: " . $e->getMessage()));
            $response = $response->withStatus(500);
        } finally {
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write($payload);
            return $response;
        }
    }

    protected function validarParametrosRequeridos($parametros)
    {
        $parametrosRequeridos = ['titulo', 'tipo', 'formato'];

        foreach ($parametrosRequeridos as $clave) {
            if (!isset($parametros[$clave]) || empty($parametros[$clave])) {
                throw new InvalidArgumentException("Debe ingresar $clave.");
            }
        }
    }

    protected function validarLogicaNegocio(array $parametros)
    {
        Validador::validarString($parametros['titulo']);
        Validador::validarTipo($parametros['tipo']);
        Validador::validarFormato($parametros['formato']);
    }
}