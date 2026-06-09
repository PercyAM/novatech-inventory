<?php

require_once "app/helpers/SessionHelper.php";

class DashboardController
{
    public function index(): void
    {
        SessionHelper::verificarSesion();

        require_once "views/dashboard/index.php";
    }
}