<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Exception;

abstract class AbstractController
{
    abstract protected function validarDatos(array $data, bool $isUpdate = false): void;

    protected function validarRequerido(array $data, string $campo, string $mensaje): void
    {
        if (!isset($data[$campo]) || trim((string) $data[$campo]) === '') {
            throw new Exception($mensaje, 400);
        }
    }
}

class PedidoController extends AbstractController
{
    public function listar(): array
    {
        return Pedido::with('detalles')->get()->toArray();
    }

    public function obtener(int $id): array
    {
        $pedido = Pedido::with('detalles')->find($id);
        if (!$pedido) {
            throw new Exception('Pedido no encontrado.', 404);
        }
        return $pedido->toArray();
    }

    public function crear(array $data): array
    {
        $this->validarDatos($data);

        $pedido = Pedido::create([
            'mesa_id'  => $data['mesa_id'],
            'fecha'    => $data['fecha'],
            'hora'     => $data['hora'],
            'subtotal' => $data['subtotal'],
            'total'    => $data['total'],
            'estado'   => 'pendiente',
        ]);

        return $pedido->toArray();
    }

    public function actualizarEstado(int $id, array $data): array
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            throw new Exception('Pedido no encontrado.', 404);
        }

        $this->validarRequerido($data, 'estado', 'El estado es obligatorio.');
        $pedido->estado = $data['estado'];
        $pedido->save();

        return $pedido->toArray();
    }

    public function eliminar(int $id): void
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            throw new Exception('Pedido no encontrado.', 404);
        }
        $pedido->delete();
    }

    protected function validarDatos(array $data, bool $isUpdate = false): void
    {
        $this->validarRequerido($data, 'mesa_id', 'La mesa es obligatoria.');
        $this->validarRequerido($data, 'fecha', 'La fecha es obligatoria.');
        $this->validarRequerido($data, 'hora', 'La hora es obligatoria.');
        $this->validarRequerido($data, 'subtotal', 'El subtotal es obligatorio.');
        $this->validarRequerido($data, 'total', 'El total es obligatorio.');
    }
}