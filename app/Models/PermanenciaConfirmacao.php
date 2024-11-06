<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermanenciaConfirmacao extends Model
{
    protected $table = 'permanencia_confirmacoes';
    
    protected $fillable = [
        'permanencia_id',
        'aluno_id',
        'nome_aluno',
        'email_aluno',
        'curso'
    ];

    public $timestamps = true;

    public function permanencia()
    {
        return $this->belongsTo(Permanencia::class);
    }

    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }
}