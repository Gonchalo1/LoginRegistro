<?php
namespace App\Services;
use Carbon\Carbon;
class AlquilerPrecioService
{
public static function calcularPrecio($comienzo, $precio_por_hora)
{
$hora_final = now();
$inicio = new Carbon($comienzo);
$totalMinutos = $hora_final->diffInMinutes($inicio);
$precioPorMinutos = $precio_por_hora / 60;
$precio_total = ceil($precioPorMinutos * $totalMinutos);
return $precio_total;
}
}