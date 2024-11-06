<?php

namespace App\Http\Controllers;

use App\Models\PermanenciaConfirmacao;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function downloadAlunosConfirmados()
    {
        // Verifica se é professor
        if (!auth()->user()->hasRole('professor')) {
            abort(403, 'Acesso não autorizado');
        }

        // Busca as confirmações das permanências do professor
        $confirmacoes = PermanenciaConfirmacao::join('permanencias', 'permanencia_confirmacoes.permanencia_id', '=', 'permanencias.id')
            ->where('permanencias.professor_id', auth()->id())
            ->orderBy('permanencias.data', 'desc')
            ->select(
                'permanencia_confirmacoes.*',
                'permanencias.data',
                'permanencias.disciplina',
                'permanencias.hora_inicio',
                'permanencias.hora_fim'
            )
            ->get();

        // Gera o PDF
        $pdf = PDF::loadView('pdf.alunos-confirmados', [
            'confirmacoes' => $confirmacoes,
            'professor' => auth()->user(),
            'dataGeracao' => Carbon::now()->format('d/m/Y H:i')
        ]);

        return $pdf->download('alunos-confirmados.pdf');
    }
} 