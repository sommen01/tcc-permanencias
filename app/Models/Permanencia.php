<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permanencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'professor_id',
        'disciplina',
        'email_do_professor',
        'status',
        'data',
        'curso',
        'turno',
        'nome_do_professor',
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'duracao',

    ];

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}
