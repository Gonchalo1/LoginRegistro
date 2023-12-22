<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Alquiler extends Model
{
use HasFactory;
protected $table = "alquileres";
protected $fillable = ["user_id", "bicicleta_id", "hora_comienzo", "hora_final",
"precio_total", "foto_url"];
public function bicicleta()
{
return $this->belongsTo(Bicicleta::class, "bicicleta_id");
}
public function user()
{
return $this->belongsTo(User::class, "user_id");
}
}