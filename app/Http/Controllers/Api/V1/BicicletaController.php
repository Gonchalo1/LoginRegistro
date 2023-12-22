<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BicicletaResource;
use App\Models\Bicicleta;
use Illuminate\Http\Request;


/*
* @group Auth
*
*/

class BicicletaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BicicletaResource::collection(Bicicleta::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "modelo" => ["required", "string", "max:255"],
            "marca" => ["required", "string", "max:255"],
            "precio_por_hora" => ["required", "integer", "min:0"],
            "foto_url" => ["required", "string"],
        ]);
    
        
    
        $bicicleta = Bicicleta::create($validated);
    
        return BicicletaResource::make($bicicleta);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Bicicleta $bicicleta)
    {
        return BicicletaResource::make($bicicleta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bicicleta $bicicleta)
    {
        $validated = $request->validate([
            "modelo" => ["required", "string", "max:255"],
            "marca" => ["required", "string", "max:255"],
            "precio_por_hora" => ["required", "integer", "min:2"],
            "foto_url" => ["required", "string"],
        ]);

        $bicicleta->update($validated);

        return BicicletaResource::make($bicicleta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bicicleta $bicicleta)
    {
        $bicicleta->delete();

        return response()->noContent();
    }
}
