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

    public function registrarEntrada(
        int $idProducto,
        int $idUsuario,
        int $cantidad,
        string $motivo,
        string $observacion
    ): bool;

    public function listarEntradasRecientes(): array;

    public function listarHistorial(array $filtros): array;

    public function obtenerProductoPorId(int $idProducto): ?array;

    public function registrarAjusteStock(
        int $idProducto,
        int $idUsuario,
        int $stockNuevo,
        int $cantidadDiferencia,
        string $tipoMovimiento,
        string $motivo,
        string $observacion
    ): bool;

    public function listarAjustesRecientes(): array;
}