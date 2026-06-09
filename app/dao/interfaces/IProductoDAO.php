<?php

interface IProductoDAO
{
    public function listar(string $busqueda = ""): array;

    public function obtenerPorId(int $idProducto): ?array;

    public function registrar(Producto $producto, DetalleProducto $detalle): bool;

    public function actualizar(Producto $producto, DetalleProducto $detalle): bool;

    public function eliminar(int $idProducto): bool;

    public function listarStockBajo(): array;
}

