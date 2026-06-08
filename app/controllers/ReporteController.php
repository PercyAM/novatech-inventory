<?php

require_once "app/helpers/SessionHelper.php";

class ReporteController
{
    public function index(): void
    {
        SessionHelper::verificarSesion();

        require_once "views/reportes/index.php";
    }
}