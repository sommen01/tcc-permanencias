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

        public function create()
    {
        return view('permanencias.create');
    }
    public function search(Request $request)
    {
        $query = $request->input('search');
        $results = Permanencia::where('nome', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->get();
    
        return view('seu_view', compact('results'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'status' => 'required|boolean',
            'data' => 'required|date',
        ]);

        $path = $request->file('foto')->store('public/images');

        Permanencia::create([
            'foto' => $path,
            'nome' => $request->nome,
            'email' => $request->email,
            'status' => $request->status,
            'data' => $request->data,
        ]);

        return redirect()->route('tables')->with('success', 'Permanência criada com sucesso.');
    }


    public function getClient()
    {
        return $this->client;
    }

    public function index()
    {
        $permanencias = Permanencia::all();
        return view('pages.tables', compact('permanencias'));
    }

    public function enviarConfirmacao(Request $request)
    {
        $request->validate([
            'permanencias' => 'required|array',
            'permanencias.*' => 'exists:permanencias,id',
        ]);
    
        $permanencias = Permanencia::whereIn('id', $request->input('permanencias'))->get();
    
        foreach ($permanencias as $permanencia) {
            Mail::to($permanencia->email)->send(new ConfirmacaoPermanencia($permanencia));
        }
    
        return redirect()->back()->with('success', 'Emails de confirmação enviados com sucesso!');
    }
    
    
    public function confirmarPermanencia($id, $token)
    {
        $permanenciaId = decrypt($token);

        $permanencia = Permanencia::findOrFail($permanenciaId);

        $client = $this->getClient();

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Confirmação de Permanência para ' . $permanencia->nome,
            'description' => 'Permanência confirmada para ' . $permanencia->nome,
            'start' => [
                'dateTime' => $permanencia->data->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
            'end' => [
                'dateTime' => $permanencia->data->addHour()->toIso8601String(),
                'timeZone' => 'America/Sao_Paulo',
            ],
        ]);

        $calendarId = 'primary';
        $service = new Google_Service_Calendar($client);
        $event = $service->events->insert($calendarId, $event);

        return redirect()->back()->with('success', 'Permanência confirmada e evento agendado no Google Calendar!');
    }

    protected function salvarEventoNoGoogleCalendar($permanencia)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
    
        if (session()->has('access_token')) {
            $client->setAccessToken(session('access_token'));
        }
    
        $service = new Google_Service_Calendar($client);
    
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
    
        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
    }


    
}


