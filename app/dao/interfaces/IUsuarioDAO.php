<?php

interface IUsuarioDAO
{
    public function listarUsuarios(): array;

    public function listarRoles(): array;

    public function registrarUsuario(array $datos): bool;

    public function existeNombreUsuario(string $nombreUsuario): bool;

    public function existeCorreo(string $correo): bool;

    public function cambiarEstado(int $idUsuario, string $estado): bool;
}