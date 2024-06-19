<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permanencia extends Model
{
    use HasFactory;

    protected $fillable = ['foto', 'nome', 'email', 'status', 'data'];

    protected $dates = ['data'];

    
}