<?php

interface IDashboardDAO
{
    public function obtenerResumenGeneral(): array;

    public function listarUltimosMovimientos(): array;

    public function listarProductosStockBajo(): array;
}