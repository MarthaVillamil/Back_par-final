<?php
declare(strict_types=1);

namespace App\Presentation\Repositories;

use App\Controllers\PedidoController;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PedidosRepository extends AbstractRepository
{
    private PedidoController $controller;

    public function __construct()
    {
        $this->controller = new PedidoController();
    }

    public function listar(Request $request, Response $response): Response
    {
        try {
            $result = $this->controller->listar();

            return $this->json($response, [
                'success' => true,
                'message' => 'Pedidos obtenidos correctamente.',
                'data'    => $result,
            ], 200);

        } catch (Exception $e) {
            return $this->jsonError($response, $e);
        }
    }

    public function obtener(Request $request, Response $response, array $args): Response
    {
        try {
            $result = $this->controller->obtener((int) $args['id']);

            return $this->json($response, [
                'success' => true,
                'message' => 'Pedido obtenido correctamente.',
                'data'    => $result,
            ], 200);

        } catch (Exception $e) {
            return $this->jsonError($response, $e);
        }
    }

    public function crear(Request $request, Response $response): Response
    {
        try {
            $data   = $this->obtenerDatos($request);
            $result = $this->controller->crear($data);

            return $this->json($response, [
                'success' => true,
                'message' => 'Pedido creado correctamente.',
                'data'    => $result,
            ], 201);

        } catch (Exception $e) {
            return $this->jsonError($response, $e);
        }
    }

    public function actualizarEstado(Request $request, Response $response, array $args): Response
    {
        try {
            $data   = $this->obtenerDatos($request);
            $result = $this->controller->actualizarEstado((int) $args['id'], $data);

            return $this->json($response, [
                'success' => true,
                'message' => 'Estado del pedido actualizado correctamente.',
                'data'    => $result,
            ], 200);

        } catch (Exception $e) {
            return $this->jsonError($response, $e);
        }
    }

    public function eliminar(Request $request, Response $response, array $args): Response
    {
        try {
            $this->controller->eliminar((int) $args['id']);

            return $this->json($response, [
                'success' => true,
                'message' => 'Pedido eliminado correctamente.',
            ], 200);

        } catch (Exception $e) {
            return $this->jsonError($response, $e);
        }
    }
}