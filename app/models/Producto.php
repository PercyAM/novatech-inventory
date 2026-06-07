<?php
declare(strict_types=1);

readonly class Producto
{
    public function __construct(
        public ?int $idProducto,
        public ?int $idDetalleProducto,
        public string $codigoProducto,
        public string $nombreProducto,
        public string $modelo,
        public int $stockActual,
        public int $stockMinimo,
        public float $precioReferencial,
        public string $descripcion,
        public string $estado
    ) {}
}