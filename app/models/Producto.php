<?php

class Producto
{
    private ?int $idProducto;
    private ?int $idDetalleProducto;
    private string $codigoProducto;
    private string $nombreProducto;
    private string $modelo;
    private int $stockActual;
    private int $stockMinimo;
    private float $precioReferencial;
    private string $descripcion;
    private string $estado;

    public function __construct(
        ?int $idProducto,
        ?int $idDetalleProducto,
        string $codigoProducto,
        string $nombreProducto,
        string $modelo,
        int $stockActual,
        int $stockMinimo,
        float $precioReferencial,
        string $descripcion,
        string $estado
    ) {
        $this->idProducto = $idProducto;
        $this->idDetalleProducto = $idDetalleProducto;
        $this->codigoProducto = $codigoProducto;
        $this->nombreProducto = $nombreProducto;
        $this->modelo = $modelo;
        $this->stockActual = $stockActual;
        $this->stockMinimo = $stockMinimo;
        $this->precioReferencial = $precioReferencial;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    public function getIdProducto(): ?int
    {
        return $this->idProducto;
    }

    public function getIdDetalleProducto(): ?int
    {
        return $this->idDetalleProducto;
    }

    public function getCodigoProducto(): string
    {
        return $this->codigoProducto;
    }

    public function getNombreProducto(): string
    {
        return $this->nombreProducto;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getStockActual(): int
    {
        return $this->stockActual;
    }

    public function getStockMinimo(): int
    {
        return $this->stockMinimo;
    }

    public function getPrecioReferencial(): float
    {
        return $this->precioReferencial;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }
}