<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frete extends Model
{
    use HasFactory;
    
    protected $table = 'fretes';
    protected $fillable = ['bairro', 'valor'];
}
