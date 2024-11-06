<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;
use App\Models\Permanencia;
use App\Mail\ConfirmacaoPermanencia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PermanenciaConfirmacao;

class PermanenciaController extends Controller
{
    protected $accessToken;
    private $client;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->client = new Google_Client();
            $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
            $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
            $this->client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);

            if (session()->has('access_token')) {
                $this->client->setAccessToken(session('access_token'));
            }

            if ($this->client->isAccessTokenExpired()) {
                $refreshToken = session('refresh_token');
                if ($refreshToken) {
                    $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
                    session(['access_token' => $this->client->getAccessToken()]);
                }
            }

            return $next($request);
        });
    }

    public function getClient()
    {
        return $this->client;
    }

    // CRUD de Permanências
    public function index()
    {
        $user = Auth::user();
        $permanencias = Permanencia::all();
        $professores = User::where('role', 'professor')->get();

        if ($user->hasRole('professor')) {
            $permanencias = $permanencias->where('professor_id', $user->id);
        }

        $eventos = $permanencias->map(function ($permanencia) {
            return [
                'id' => $permanencia->id,
                'title' => $permanencia->disciplina,
                'start' => $permanencia->data,
                'extendedProps' => [
                    'disciplina' => $permanencia->disciplina,
                    'curso' => $permanencia->curso,
                    'turno' => $permanencia->turno,
                    'nome_do_professor' => $permanencia->nome_do_professor,
                    'email_do_professor' => $permanencia->email_do_professor,
                    'status' => $permanencia->status,
                ]
            ];
        });

        return view('pages.tables', compact('permanencias', 'eventos', 'professores'));
    }
    // public function index()
    // {
    //     $permanencias = Permanencia::all();
    //     return view('pages.tables', compact('permanencias'));
    // }

    public function create()
    {
        $professores = User::where('role', 'professor')->get();
        return view('permanencias.create', compact('professores'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dia_semana' => 'required|integer|min:1|max:7',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
            'disciplina' => 'required',
            'curso' => 'required',
            'turno' => 'required',
            'professor_id' => 'required|exists:users,id',
            'email_do_professor' => 'required|email',
            'status' => 'required|boolean',
            'duracao' => 'required|in:unica,semestre',
            'sala' => 'nullable|string|max:255',

        ]);
    
        $professor = User::findOrFail($validatedData['professor_id']);
    
        $validatedData['nome_do_professor'] = $professor->name;
    
        $diaSemana = $validatedData['dia_semana'];
        $dataInicio = Carbon::now();
        while ($dataInicio->dayOfWeek != $diaSemana) {
            $dataInicio->addDay();
        }
        $validatedData['data'] = $dataInicio->format('Y-m-d');
    
        $permanencia = Permanencia::create($validatedData);
    
        return redirect()->route('permanencias.index')->with('success', 'Permanência criada com sucesso!');
    }
    public function edit(Permanencia $permanencia)
    {
        $professores = User::where('role', 'professor')->get();
        return view('permanencias.edit', compact('permanencia', 'professores'));
    }

    public function baixarPdf()
    {
        $dados = Permanencia::all();
        $pdf = PDF::loadView('pages.pdf', compact('dados'));
        return $pdf->download('tabela.pdf');
    }
    public function update(Request $request, Permanencia $permanencia)
    {
        if (Auth::id() !== $permanencia->professor_id) {
            return redirect()->route('permanencias.index')->with('error', 'Você não tem permissão para editar esta permanência.');
        }

        $validatedData = $request->validate([
            'dia_semana' => 'required|integer|between:1,7',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'disciplina' => 'required|string|max:255',
            'curso' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'professor_id' => 'required|exists:users,id',
            'email_do_professor' => 'required|email',
            'status' => 'required|boolean',
            'duracao' => 'required|in:unica,semestre',
            'sala' => 'required|string|max:255',
        ]);

        $permanencia->update($validatedData);

        return redirect()->route('tables')->with('success', 'Permanência atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $permanencia = Permanencia::findOrFail($id);
        $permanencia->delete();

        return redirect()->route('tables')->with('success', 'Permanência excluída com sucesso.');
    }

    public function excluir(Request $request)
    {
        try {
            $permanencia = Permanencia::findOrFail($request->permanencia_id);
            
            if ($permanencia->professor_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Você não tem permissão para excluir esta permanência.']);
            }

            $permanencia->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function enviarConfirmacao(Request $request)
    {
        $request->validate([
            'permanencias' => 'required|array',
            'permanencias.*' => 'exists:permanencias,id',
        ]);
    
        $user = auth()->user();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não autenticado.');
        }
    
        $permanencias = Permanencia::whereIn('id', $request->input('permanencias'))->get();
    
        foreach ($permanencias as $permanencia) {
            $icsContent = $this->gerarConviteICalendar($permanencia);
    
            Mail::to($user->email)
                ->send(new ConfirmacaoPermanencia($permanencia, $icsContent));
    
            $this->salvarEventoNoGoogleCalendar($permanencia);
        }
    
        return redirect()->back()->with('success', 'Emails de confirmação enviados com sucesso!');
    }
    
    
    
    
    protected function gerarConviteICalendar($permanencia)
    {
        $startDateTime = Carbon::parse($permanencia->data);
        $endDateTime = Carbon::parse($permanencia->data)->addHour();
    
        $icsContent = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Example Corp.//NONSGML Event//EN
BEGIN:VEVENT
UID:" . uniqid() . "@example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:" . $startDateTime->format('Ymd\THis\Z') . "
DTEND:" . $endDateTime->format('Ymd\THis\Z') . "
SUMMARY:Confirmação de Permanência para " . $permanencia->nome_do_professor . "
DESCRIPTION:Permanência confirmada para " . $permanencia->nome_do_professor . "
LOCATION:Local do Evento
END:VEVENT
END:VCALENDAR";
    
        return $icsContent;

    }

    public function confirmarPermanencia(Request $request)
    {
        try {
            // Validação básica do request
            $request->validate([
                'permanencia_id' => 'required|exists:permanencias,id'
            ]);

            $permanencia = Permanencia::findOrFail($request->permanencia_id);
            
            // Verifica se a permanência está no horário válido
            $agora = now();
            $dataHoraFim = Carbon::parse($permanencia->data)->setTimeFromTimeString($permanencia->hora_fim);
            
            if ($agora->isAfter($dataHoraFim)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta permanência já foi encerrada.'
                ]);
            }
            
            // Verifica se o aluno já confirmou
            $jaConfirmou = PermanenciaConfirmacao::where('permanencia_id', $permanencia->id)
                ->where('aluno_id', Auth::id())
                ->exists();
                
            if ($jaConfirmou) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você já confirmou presença nesta permanência.'
                ]);
            }
            
            // Salva a confirmação
            PermanenciaConfirmacao::create([
                'permanencia_id' => $permanencia->id,
                'aluno_id' => Auth::id(),
                'nome_aluno' => Auth::user()->name,
                'email_aluno' => Auth::user()->email,
                'curso' => Auth::user()->curso ?? 'Não informado' 
            ]);
            
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Erro ao confirmar permanência: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao confirmar presença: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listarConfirmados(Request $request)
    {
        $permanencia = Permanencia::findOrFail($request->permanencia_id);
        
        // Limpa confirmações antigas
        $this->limparConfirmacoesAntigas($permanencia);
        
        $confirmacoes = PermanenciaConfirmacao::where('permanencia_id', $permanencia->id)
            ->select('nome_aluno as nome', 'email_aluno as email', 'curso')
            ->get();
        
        return response()->json(['alunos' => $confirmacoes]);
    }

    private function limparConfirmacoesAntigas($permanencia)
    {
        $dataHoraFim = Carbon::parse($permanencia->data)->setTimeFromTimeString($permanencia->hora_fim);
        
        if (now()->isAfter($dataHoraFim)) {
            PermanenciaConfirmacao::where('permanencia_id', $permanencia->id)->delete();
        }
    }

    protected function salvarEventoNoGoogleCalendar($permanencia)
    {
        $client = $this->getClient();
    
        $currentDate = Carbon::now();
        $diaSemana = $permanencia->dia_semana;
        $diffDays = ($diaSemana - $currentDate->dayOfWeek + 7) % 7;
        $nextOccurrence = $currentDate->copy()->addDays($diffDays);
    
        if ($nextOccurrence->lessThanOrEqualTo($currentDate)) {
            $nextOccurrence->addWeek();
        }
    
        $startDateTime = Carbon::parse($nextOccurrence->format('Y-m-d') . ' ' . $permanencia->hora_inicio);
        $endDateTime = Carbon::parse($nextOccurrence->format('Y-m-d') . ' ' . $permanencia->hora_fim);
    
        $event = new Google_Service_Calendar_Event([
            'summary' => 'Confirmação de Permanência para ' . $permanencia->nome_do_professor,
            'description' => 'Permanência confirmada para ' . $permanencia->nome_do_professor,
            'start' => [
                'dateTime' => $startDateTime->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
            'end' => [
                'dateTime' => $endDateTime->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
        ]);
    
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
    }
    
    

}
