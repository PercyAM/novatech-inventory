<?php

class DetalleProducto
{
    private ?int $idDetalleProducto;
    private string $categoria;
    private string $marca;
    private string $descripcion;

    public function __construct(
        ?int $idDetalleProducto,
        string $categoria,
        string $marca,
        string $descripcion
    ) {
        $this->idDetalleProducto = $idDetalleProducto;
        $this->categoria = $categoria;
        $this->marca = $marca;
        $this->descripcion = $descripcion;
    }

    public function getIdDetalleProducto(): ?int
    {
        return $this->idDetalleProducto;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
}