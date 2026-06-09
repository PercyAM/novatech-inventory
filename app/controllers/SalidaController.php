<?php

require_once "app/helpers/SessionHelper.php";

class SalidaController
{
    public function index(): void
    {
        SessionHelper::verificarSesion();

        require_once "views/salidas/index.php";
    }
}