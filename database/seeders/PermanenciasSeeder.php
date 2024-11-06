<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permanencia;
use App\Models\User;
use Carbon\Carbon;

class PermanenciasSeeder extends Seeder
{
    public function run()
    {
        // Pegar professores existentes
        $professores = User::where('role', 'professor')->get()->map(function($user) {
            return [
                'nome' => $user->name,
                'email' => $user->email,
                'id' => $user->id
            ];
        })->toArray();

        if (empty($professores)) {
            throw new \Exception('Nenhum professor encontrado no sistema. Cadastre alguns professores primeiro.');
        }

        $disciplinas = [
            'Matemática',
            'Português',
            'História',
            'Geografia',
            'Biologia',
            'Física',
            'Química',
            'Inglês'
        ];

        $cursos = [
            'Informática',
            'Mecânica',
            'Eletrotécnica'
        ];

        $turnos = [
            'Matutino',
            'Vespertino',
            'Noturno'
        ];

        $salas = ['Sala 101', 'Sala 102', 'Sala 103', 'Sala 201', 'Sala 202'];

        // Gerar 10 permanências
        for ($i = 0; $i < 10; $i++) {
            $dataInicio = Carbon::now()->addDays(rand(1, 30));
            $horaInicio = str_pad(rand(8, 16), 2, '0', STR_PAD_LEFT) . ':00:00';
            $horaFim = Carbon::parse($horaInicio)->addHours(2)->format('H:i:s');
            
            $professor = $professores[array_rand($professores)];

            Permanencia::create([
                'disciplina' => $disciplinas[array_rand($disciplinas)],
                'curso' => $cursos[array_rand($cursos)],
                'turno' => $turnos[array_rand($turnos)],
                'nome_do_professor' => $professor['nome'],
                'email_do_professor' => $professor['email'],
                'professor_id' => $professor['id'],
                'status' => rand(0, 1),
                'data' => $dataInicio->format('Y-m-d'),
                'sala' => $salas[array_rand($salas)],
                'hora_inicio' => $horaInicio,
                'hora_fim' => $horaFim,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
} 