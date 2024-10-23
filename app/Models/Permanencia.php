<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'sala'

    ];

    protected $dates = ['data', 'hora_inicio', 'hora_fim'];

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function getHoraInicioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getHoraFimAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function setHoraInicioAttribute($value)
    {
        $this->attributes['hora_inicio'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function setHoraFimAttribute($value)
    {
        $this->attributes['hora_fim'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function getDataAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
