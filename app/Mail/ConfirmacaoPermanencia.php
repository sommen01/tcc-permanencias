<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Permanencia;

class ConfirmacaoPermanencia extends Mailable
{
    use Queueable, SerializesModels;

    public $permanencia;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Permanencia $permanencia)
    {
        $this->permanencia = $permanencia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dataConfirmacao = Carbon::parse($this->permanencia->data);
    
        return $this->view('emails.confirmacao_permanencia')
                    ->subject('Confirmação de Permanência')
                    ->with([
                        'nome' => $this->permanencia->nome,
                        'dataConfirmacao' => $dataConfirmacao,
                    ]);
    }
    
}
