<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Permanencia;
class ConfirmacaoPermanencia extends Mailable
{
    use Queueable, SerializesModels;

    public $permanencia;
    public $icsContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($permanencia, $icsContent)
    {
        $this->permanencia = $permanencia;
        $this->icsContent = $icsContent; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dataConfirmacao = Carbon::parse($this->permanencia->data);
        return $this->view('emails.confirmacao_permanencia', [
            'permanencia' => $this->permanencia,
            'nome' => $this->permanencia->nome, 
            'dataConfirmacao' => $dataConfirmacao,

        ])
        ->subject('Confirmação de Permanência')
        ->attachData($this->icsContent, 'convite.ics', [
            'mime' => 'text/calendar',
        ]);

    }
}
