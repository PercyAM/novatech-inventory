<?php

interface IMovimientoDAO
{
    public function listarProductosDisponibles(): array;

    public function registrarSalida(
        int $idProducto,
        int $idUsuario,
        int $cantidad,
        string $motivo,
        string $observacion
    ): bool;

    public function listarSalidasRecientes(): array;

    public function listarHistorial(array $filtros): array;
}