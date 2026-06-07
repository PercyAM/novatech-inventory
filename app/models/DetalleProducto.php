<?php
declare(strict_types=1);

readonly class DetalleProducto
{
    public function __construct(
        public ?int $idDetalleProducto,
        public string $categoria,
        public string $marca,
        public string $descripcion
    ) {}
}