<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;
use App\Models\Permanencia;
use App\Mail\ConfirmacaoPermanencia;

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
        $permanencias = Permanencia::all(); // ou sua lógica de consulta atual
        $eventos = [];
    
        foreach ($permanencias as $permanencia) {
            $dataInicial = Carbon::parse($permanencia->data);
            $diaDaSemana = $dataInicial->dayOfWeek;
    
            // Gerar eventos para os próximos 3 meses
            $dataFinal = Carbon::now()->addMonths(12);
    
            while ($dataInicial <= $dataFinal) {
                $eventos[] = [
                    'title' => $permanencia->nome_do_professor,
                    'start' => $dataInicial->format('Y-m-d'),
                    'extendedProps' => [
                        'disciplina' => $permanencia->disciplina,
                        'curso' => $permanencia->curso,
                        'turno' => $permanencia->turno,
                        'nome_do_professor' => $permanencia->nome_do_professor,
                        'email_do_professor' => $permanencia->email_do_professor,
                        'status' => $permanencia->status,
                    ],
                ];
    
                $dataInicial->addWeek();
            }
        }
    
        return view('pages.tables', compact('permanencias', 'eventos'));
    }
    // public function index()
    // {
    //     $permanencias = Permanencia::all();
    //     return view('pages.tables', compact('permanencias'));
    // }

    public function create()
    {
        return view('permanencias.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nome_do_professor' => 'required|string|max:255',
            'email_do_professor' => 'required|email|max:255',
            'status' => 'required|boolean',
            'disciplina' => 'required|string|max:255',
            'curso' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'dia_semana' => 'required|integer|min:0|max:6',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);
    
        $path = $request->file('foto')->store('public/images');
    
        $currentDate = Carbon::now();
        $diaSemana = $request->dia_semana;
        $diffDays = ($diaSemana - $currentDate->dayOfWeek + 7) % 7;
        $firstOccurrence = $currentDate->copy()->addDays($diffDays);
    
        if ($firstOccurrence->lessThanOrEqualTo($currentDate)) {
            $firstOccurrence->addWeek();
        }
    
        $startDateTime = Carbon::parse($firstOccurrence->format('Y-m-d') . ' ' . $request->hora_inicio);
        $endDateTime = Carbon::parse($firstOccurrence->format('Y-m-d') . ' ' . $request->hora_fim);
    
        Permanencia::create([
            'foto' => $path,
            'nome_do_professor' => $request->nome_do_professor,
            'email_do_professor' => $request->email_do_professor,
            'status' => $request->status,
            'disciplina' => $request->disciplina,
            'curso' => $request->curso,
            'turno' => $request->turno,
            'data' => $startDateTime,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
        ]);
    
        return redirect()->route('tables')->with('success', 'Permanência criada com sucesso.');
    }
    
    
    public function edit($id)
    {
        $permanencia = Permanencia::findOrFail($id);
        return view('permanencias.edit', compact('permanencia'));
    }

    public function update(Request $request, $id)
    {
        $permanencia = Permanencia::findOrFail($id);

        $request->validate([
            'nome_do_professor' => 'required|string|max:255',
            'email_do_professor' => 'required|email|max:255',
            'status' => 'required|boolean',
            'disciplina' => 'required|string|max:255',
            'curso' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'dia_semana' => 'required|integer|min:1|max:7',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/images');
            $permanencia->foto = $path;
        }

        $diaSemana = $request->dia_semana;
        $horaInicio = $request->hora_inicio;
        $horaFim = $request->hora_fim;

        $currentDate = Carbon::now();
        $endDate = $currentDate->copy()->addMonths(6);
        
        $dates = [];
        
        while ($currentDate->lessThan($endDate)) {
            if ($currentDate->dayOfWeekIso == $diaSemana) {
                $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $horaInicio);
                $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $horaFim);
                
                $dates[] = [
                    'foto' => $path ?? $permanencia->foto,
                    'nome_do_professor' => $request->nome_do_professor,
                    'email_do_professor' => $request->email_do_professor,
                    'status' => $request->status,
                    'data' => $startDateTime->format('Y-m-d H:i:s'),
                    'disciplina' => $request->disciplina,
                    'curso' => $request->curso,
                    'turno' => $request->turno,
                ];
            }
            $currentDate->addDay();
        }

        Permanencia::where('id', $id)->update($dates);

        return redirect()->route('tables')->with('success', 'Permanência atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $permanencia = Permanencia::findOrFail($id);
        $permanencia->delete();

        return redirect()->route('tables')->with('success', 'Permanência excluída com sucesso.');
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

    public function confirmarPermanencia($id, $token)
    {
        $permanenciaId = decrypt($token);

        $permanencia = Permanencia::findOrFail($permanenciaId);

        Mail::to($permanencia->email_do_professor)->send(new ConfirmacaoPermanencia($permanencia));
        $this->salvarEventoNoGoogleCalendar($permanencia);

        return redirect()->back()->with('success', 'Permanência confirmada e evento agendado no Google Calendar!');
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
