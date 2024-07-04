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


    public function index(Request $request)
    {
        $query = Permanencia::query();
    
        if ($request->filled('curso')) {
            $query->orderByRaw("curso = '{$request->curso}' DESC");
        }
    
        if ($request->filled('disciplina')) {
            $query->orderByRaw("disciplina = '{$request->disciplina}' DESC");
        }
    
        if ($request->filled('turno')) {
            $query->orderByRaw("turno = '{$request->turno}' DESC");
        }
    
        if ($request->filled('nome_do_professor')) {
            $query->orderByRaw("nome_do_professor LIKE '%{$request->nome_do_professor}%' DESC");
        }
    
        $permanencias = $query->get();
    
        return view('pages.tables', compact('permanencias'));
    }
    
    

    public function create()
    {
        return view('permanencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'disciplina' => 'required|string|max:255',
            'email_do_professor' => 'required|email|max:255',
            'status' => 'required|boolean',
            'data' => 'required|date',
            'curso' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'nome_do_professor' => 'required|string|max:255',
        ]);
    
        $path = $request->file('foto')->store('public/images');
    
        Permanencia::create([
            'foto' => $path,
            'disciplina' => $request->disciplina,
            'email_do_professor' => $request->email_do_professor,
            'status' => $request->status,
            'data' => $request->data,
            'curso' => $request->curso,
            'turno' => $request->turno,
            'nome_do_professor' => $request->nome_do_professor,
        ]);
    
        return redirect()->route('tables')->with('success', 'Permanência criada com sucesso.');
    }
    
    public function update(Request $request, $id)
    {
        $permanencia = Permanencia::findOrFail($id);
    
        $request->validate([
            'disciplina' => 'required|string|max:255',
            'email_do_professor' => 'required|email|max:255',
            'status' => 'required|boolean',
            'data' => 'required|date',
            'curso' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'nome_do_professor' => 'required|string|max:255',
        ]);
    
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/images');
            $permanencia->foto = $path;
        }
    
        $permanencia->disciplina = $request->disciplina;
        $permanencia->email_do_professor = $request->email_do_professor;
        $permanencia->status = $request->status;
        $permanencia->data = $request->data;
        $permanencia->curso = $request->curso;
        $permanencia->turno = $request->turno;
        $permanencia->nome_do_professor = $request->nome_do_professor;
        $permanencia->save();
    
        return redirect()->route('tables')->with('success', 'Permanência atualizada com sucesso.');
    }
    

    public function edit($id)
    {
        $permanencia = Permanencia::findOrFail($id);
        return view('permanencias.edit', compact('permanencia'));
    }

  
    public function destroy($id)
    {
        $permanencia = Permanencia::findOrFail($id);
        $permanencia->delete();

        return redirect()->route('tables')->with('success', 'Permanência excluída com sucesso.');
    }

    // Funções relacionadas ao Google Calendar

    public function enviarConfirmacao(Request $request)
    {
        $request->validate([
            'permanencias' => 'required|array',
            'permanencias.*' => 'exists:permanencias,id',
        ]);
    
        $permanencias = Permanencia::whereIn('id', $request->input('permanencias'))->get();
    
        foreach ($permanencias as $permanencia) {
            $icsContent = $this->gerarConviteICalendar($permanencia);
            
            Mail::to($permanencia->email)
                ->send(new ConfirmacaoPermanencia($permanencia, $icsContent));
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
SUMMARY:Confirmação de Permanência para " . $permanencia->nome . "
DESCRIPTION:Permanência confirmada para " . $permanencia->nome . "
LOCATION:Local do Evento
END:VEVENT
END:VCALENDAR";
    
        return $icsContent;

    }


    public function confirmarPermanencia($id, $token)
    {
        $permanenciaId = decrypt($token);

        $permanencia = Permanencia::findOrFail($permanenciaId);

        Mail::to($permanencia->email)->send(new ConfirmacaoPermanencia($permanencia));
        $this->salvarEventoNoGoogleCalendar($permanencia);

        return redirect()->back()->with('success', 'Permanência confirmada e evento agendado no Google Calendar!');
    }

    protected function salvarEventoNoGoogleCalendar($permanencia)
    {
        $client = $this->getClient();

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Confirmação de Permanência para ' . $permanencia->nome,
            'description' => 'Permanência confirmada para ' . $permanencia->nome,
            'start' => [
                'dateTime' => Carbon::parse($permanencia->data)->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
            'end' => [
                'dateTime' => Carbon::parse($permanencia->data)->addHour()->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
        ]);

        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
    }
}

