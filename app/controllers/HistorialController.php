<?php

require_once "app/helpers/SessionHelper.php";

class HistorialController
{
    public function index(): void
    {
        SessionHelper::verificarSesion();

        require_once "views/historial/index.php";
    }
}