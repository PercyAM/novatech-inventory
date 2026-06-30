<?php

interface IReporteDAO
{
    public function obtenerResumenGeneral(): array;

    public function listarInventario(): array;

    public function listarStockBajo(): array;

    public function listarMovimientosRecientes(): array;
}