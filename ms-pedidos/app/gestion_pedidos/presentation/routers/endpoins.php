<?php
declare(strict_types=1);

use App\Presentation\Repositories\PedidosRepository;

return function ($app) {
    $repository = new PedidosRepository();

    // Listar todos los pedidos
    $app->get('/pedidos', [$repository, 'listar']);

    // Obtener un pedido por ID
    $app->get('/pedidos/{id}', [$repository, 'obtener']);

    // Crear un pedido
    $app->post('/pedidos', [$repository, 'crear']);

    // Actualizar estado de un pedido
    $app->put('/pedidos/{id}/estado', [$repository, 'actualizarEstado']);

    // Eliminar un pedido
    $app->delete('/pedidos/{id}', [$repository, 'eliminar']);
};