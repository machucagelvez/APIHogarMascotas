<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloMascota extends Model
{
    protected $table = 'mascota';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'nombre', 'edad', 'tipo', 'descripcion', 'comida'];
}