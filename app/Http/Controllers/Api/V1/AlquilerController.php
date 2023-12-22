<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlquilerResource;
use App\Models\Alquiler;
use App\Services\AlquilerPrecioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/*
* @group Alquiler
*
*/
class AlquilerController extends Controller
{
public function index(Request $request)
{
$alquileres = Alquiler::where('user_id', $request->user()->id)
->paginate();
return AlquilerResource::collection($alquileres);
}
public function inicio(Request $request)
{
$request->validate([
"bicicleta_id" => ["required", "integer", "exists:bicicletas,id"],
]);
if (Alquiler::where('bicicleta_id', $request->bicicleta_id)
->whereNull('hora_final')
->exists()
) {
return response()->json([
'errors' => ['general' => ['La bicicleta no se encuentra disponible']],
], Response::HTTP_UNPROCESSABLE_ENTITY);
}
$alquiler = Alquiler::create([
"bicicleta_id" => $request->bicicleta_id,
"hora_comienzo" => now(),
"user_id" => $request->user()->id,
]);
$alquiler->load('bicicleta');
return AlquilerResource::make($alquiler);
}
public function finalizar(Alquiler $alquiler, Request $request)
{
if ($alquiler->hora_final !== null) {
return response()->json([
'errors' => ['general' => ['El alquiler ya ha sido finalizado']],
], Response::HTTP_UNPROCESSABLE_ENTITY);
}
if ($alquiler->user->id !== $request->user()->id) {
return response()->json([
'errors' => ['general' => ['El alquiler no pertenece al usuario']],
], Response::HTTP_UNPROCESSABLE_ENTITY);
}
$precioTotal = AlquilerPrecioService::calcularPrecio($alquiler->hora_comienzo,
$alquiler->bicicleta->precio_por_hora);
$alquiler->precio_total = $precioTotal;
 $alquiler->hora_final = now();
$alquiler->save();
return AlquilerResource::make($alquiler);
}
}