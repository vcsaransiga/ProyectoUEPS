<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorProyecto extends Model
{
    use HasFactory;

    protected $table = 'vendedor_proyecto';
    protected $fillable = ['vendedor_id', 'proyecto_id'];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }
}
