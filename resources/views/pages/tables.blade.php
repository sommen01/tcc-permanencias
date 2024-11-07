<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Permanências"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div id="snackbar" class="show">{{ session('success') }}</div>
                    @endif
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">Permanências</h6>

                                    <div class="d-flex gap-2">
                                        @if (Auth::user()->hasRole('professor'))
                                            <a href="{{ route('permanencias.create') }}"
                                                class="btn btn-success btn-outline-white"
                                                style="border: 2px solid white;">
                                                <i class="material-icons">add</i>
                                                <span>Cadastrar</span>
                                            </a>
                                            <a href="{{ route('download.alunos-confirmados') }}"
                                                class="btn btn-success btn-outline-white"
                                                style="border: 2px solid white;">
                                                <i class="material-icons">download</i>
                                                <span>Baixar PDF Alunos</span>
                                            </a>
                                        @endif

                                        @if (Auth::user()->hasRole('aluno'))
                                            <a href="{{ route('tabela.pdf') }}"
                                                class="btn btn-success btn-outline-white"
                                                style="border: 2px solid white;">
                                                <i class="material-icons">download</i>
                                                <span>Baixar PDF</span>
                                            </a>
                                        @endif

                                        <button type="button" class="btn btn-success btn-outline-white"
                                            data-bs-toggle="modal" data-bs-target="#filterModal"
                                            style="border: 2px solid white;">
                                            <i class="material-icons">filter_list</i>
                                            <span>Filtrar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">


                            <!-- Modal de Filtros -->
                            <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title text-white" id="filterModalLabel">Filtros</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Filtros -->
                                            <div class="row mb-3">
                                                <div class="col-12 mb-3">
                                                    <div class="input-group input-group-outline">
                                                        <select class="form-control filter-select" name="curso"
                                                            id="curso">
                                                            <option value="">Curso</option>
                                                            <option value="Informática">Informática</option>
                                                            <option value="Mecânica">Mecânica</option>
                                                            <option value="Eletrotécnica">Eletrotécnica</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="input-group input-group-outline">
                                                        <select class="form-control filter-select" name="disciplina"
                                                            id="disciplina">
                                                            <option value="">Disciplina</option>
                                                            <option value="Matemática">Matemática</option>
                                                            <option value="Português">Português</option>
                                                            <option value="História">História</option>
                                                            <option value="Geografia">Geografia</option>
                                                            <option value="Biologia">Biologia</option>
                                                            <option value="Física">Física</option>
                                                            <option value="Química">Química</option>
                                                            <option value="Inglês">Inglês</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="input-group input-group-outline">
                                                        <select class="form-control filter-select" name="turno"
                                                            id="turno">
                                                            <option value="">Turno</option>
                                                            <option value="Matutino">Matutino</option>
                                                            <option value="Vespertino">Vespertino</option>
                                                            <option value="Noturno">Noturno</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group input-group-outline">
                                                        <select class="form-control filter-select"
                                                            name="nome_do_professor" id="nome_do_professor">
                                                            <option value="">Nome do Professor</option>
                                                            @foreach ($professores as $professor)
                                                                <option value="{{ $professor->name }}">
                                                                    {{ $professor->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fechar</button>
                                            <button type="button" class="btn btn-success" id="aplicarFiltros">Aplicar
                                                Filtros</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Conteúdo Principal (Tabela + Lista de Confirmados/Calendário) -->
                            <div class="row">
                                <!-- Coluna da Tabela (Lado Esquerdo) -->
                                <div class="col-12 col-lg-6">
                                    <div class="card mx-3 mt-3">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Disciplina</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                            Curso</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Turno</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Nome do Professor</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Email do Professor</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Status</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Data</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Sala</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Horário</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            @if (Auth::user()->hasRole('professor'))
                                                                AÇÕES
                                                            @else
                                                                CONFIRMAR PRESENÇA
                                                            @endif
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($permanencias as $permanencia)
                                                        @php
                                                            $dataHoraInicio = \Carbon\Carbon::parse(
                                                                $permanencia->data,
                                                            )->setTimeFromTimeString($permanencia->hora_inicio);
                                                            $dataHoraFim = \Carbon\Carbon::parse(
                                                                $permanencia->data,
                                                            )->setTimeFromTimeString($permanencia->hora_fim);
                                                            $agora = \Carbon\Carbon::now();
                                                            $podeConfirmar = $agora->lessThan($dataHoraFim);
                                                        @endphp
                                                        <tr class="permanencia-row">
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $permanencia->disciplina }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-xs font-weight-bold mb-0">
                                                                    {{ $permanencia->curso }}</p>
                                                            </td>
                                                            <td class="align-middle text-center text-sm">
                                                                <span
                                                                    class="badge badge-sm bg-gradient-success">{{ $permanencia->turno }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ $permanencia->nome_do_professor }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ $permanencia->email_do_professor }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ $permanencia->status ? 'Disponível' : 'Indisponível' }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($permanencia->data)->format('d/m/Y') }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ $permanencia->sala }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="text-secondary text-xs font-weight-bold">
                                                                    {{ \Carbon\Carbon::parse($permanencia->hora_inicio)->format('H:i') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($permanencia->hora_fim)->format('H:i') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if (Auth::user()->hasRole('professor'))
                                                                    <a href="{{ route('permanencias.edit', $permanencia->id) }}"
                                                                        class="btn btn-info btn-sm">
                                                                        <i class="material-icons">edit</i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('permanencias.destroy', $permanencia->id) }}"
                                                                        method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm">
                                                                            <i class="material-icons">delete</i>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-success btn-sm"
                                                                        onclick="confirmarPresenca({{ $permanencia->id }})">
                                                                        <i class="material-icons">check</i> Confirmar
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coluna Direita -->
                                <div class="col-12 col-lg-6">
                                    @if (Auth::user()->hasRole('professor'))
                                        <!-- Lista de Alunos Confirmados -->
                                        <div class="card">
                                            <div class="card-header p-3">
                                                <h6 class="mb-0">Alunos Confirmados</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="table-responsive">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Aluno</th>
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                    Curso</th>
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                    Email</th>
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                    Permanência</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($permanencias as $permanencia)
                                                                @php
                                                                    $confirmacoes = \App\Models\PermanenciaConfirmacao::where(
                                                                        'permanencia_id',
                                                                        $permanencia->id,
                                                                    )
                                                                        ->orderBy('created_at', 'desc')
                                                                        ->get();
                                                                @endphp

                                                                @foreach ($confirmacoes as $confirmacao)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        {{ $confirmacao->nome_aluno }}
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p class="text-xs font-weight-bold mb-0">
                                                                                {{ $confirmacao->curso }}</p>
                                                                        </td>
                                                                        <td>
                                                                            <p class="text-xs text-secondary mb-0">
                                                                                {{ $confirmacao->email_aluno }}</p>
                                                                        </td>
                                                                        <td>
                                                                            <p class="text-xs text-secondary mb-0">
                                                                                {{ \Carbon\Carbon::parse($permanencia->data)->format('d/m/Y') }}
                                                                                - {{ $permanencia->disciplina }}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Calendário para Alunos -->
                                        <div class="card">
                                            <div class="card-header p-3">
                                                <h6 class="mb-0">Calendário de Permanências</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Modal de detalhes da permanência -->
                            <div class="modal fade" id="permanenciaModal" tabindex="-1"
                                aria-labelledby="permanenciaModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="permanenciaModalLabel">Detalhes da
                                                Permanência</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Disciplina:</strong> <span id="modalDisciplina"></span></p>
                                            <p><strong>Curso:</strong> <span id="modalCurso"></span></p>
                                            <p><strong>Turno:</strong> <span id="modalTurno"></span></p>
                                            <p><strong>Professor:</strong> <span id="modalProfessor"></span></p>
                                            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                                            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                                            <p><strong>Duração:</strong> <span id="modalDuracao"></span></p>
                                            <p><strong>Sala:</strong> <span id="modalSala"></span></p>
                                            <p><strong>Horário Inicial:</strong> <span id="modalHorarioInicial"></span>
                                            </p>
                                            <p><strong>Horário Final:</strong> <span id="modalHorarioFinal"></span>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fechar</button>
                                            <button type="button" class="btn btn-primary"
                                                id="confirmarPermanencia">Confirmar Permanência</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'pt-BR',
                    events: generateRecurringEvents(@json($permanencias)),
                    eventClick: function(info) {
                        var evento = info.event;
                        document.getElementById('modalDisciplina').textContent = evento.extendedProps
                            .disciplina;
                        document.getElementById('modalCurso').textContent = evento.extendedProps.curso;
                        document.getElementById('modalTurno').textContent = evento.extendedProps.turno;
                        document.getElementById('modalProfessor').textContent = evento.extendedProps
                            .nome_do_professor;
                        document.getElementById('modalEmail').textContent = evento.extendedProps
                            .email_do_professor;
                        document.getElementById('modalStatus').textContent = evento.extendedProps
                            .status === '1' ? 'Ativo' : 'Inativo';
                        document.getElementById('modalDuracao').textContent = evento.extendedProps
                            .duracao;
                        document.getElementById('modalSala').textContent = evento.extendedProps.sala ||
                            'Não especificada';
                        document.getElementById('modalHorarioInicial').textContent = evento
                            .extendedProps.hora_inicio || 'Não especificado';
                        document.getElementById('modalHorarioFinal').textContent = evento.extendedProps
                            .hora_fim || 'Não especificado';

                        $('#permanenciaModal').modal('show');
                    },
                    height: '800px',
                    buttonText: {
                        today: 'Hoje'
                    }
                });
                calendar.render();
            }

            function formatTime(time) {
                if (!time) return '';
                let [hours, minutes] = time.split(':');
                hours = hours.padStart(2, '0');
                minutes = minutes.padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            function generateRecurringEvents(permanencias) {
                var events = [];
                var today = new Date();
                var sixMonthsLater = new Date(today.getFullYear(), today.getMonth() + 6, today.getDate());

                permanencias.forEach(function(permanencia) {
                    var startDate = new Date(permanencia.data);
                    var endDate = permanencia.duracao === 'semestre' ? sixMonthsLater : new Date(startDate);

                    while (startDate <= endDate) {
                        var eventDate = new Date(startDate);
                        var formattedTime = formatTime(permanencia.hora_inicio);
                        var [hours, minutes] = formattedTime.split(':');
                        eventDate.setHours(parseInt(hours), parseInt(minutes), 0);

                        events.push({
                            id: permanencia.id,
                            title: ` - ${permanencia.disciplina} - ${permanencia.nome_do_professor}`,
                            start: eventDate,
                            allDay: false,
                            extendedProps: {
                                disciplina: permanencia.disciplina,
                                curso: permanencia.curso,
                                turno: permanencia.turno,
                                nome_do_professor: permanencia.nome_do_professor,
                                email_do_professor: permanencia.email_do_professor,
                                status: permanencia.status,
                                duracao: permanencia.duracao,
                                sala: permanencia.sala,
                                hora_inicio: formatTime(permanencia.hora_inicio),
                                hora_fim: formatTime(permanencia.hora_fim)
                            }
                        });

                        if (permanencia.duracao === 'unica') {
                            break;
                        }

                        startDate.setDate(startDate.getDate() + 7);
                    }
                });

                return events;
            }

            // Mantém a função de filtro original
            $(document).ready(function() {
                var originalRows = $('.permanencia-row').get();

                // Manipulador do botão Aplicar Filtros
                $('#aplicarFiltros').on('click', function() {
                    filterTable();
                    $('#filterModal').modal('hide');
                });

                function filterTable() {
                    var curso = $('#curso').val().toLowerCase();
                    var disciplina = $('#disciplina').val().toLowerCase();
                    var turno = $('#turno').val().toLowerCase();
                    var nomeProfessor = $('#nome_do_professor').val().toLowerCase();

                    // Clonar as linhas originais
                    var rows = originalRows.slice();

                    // Ordenar as linhas
                    rows.sort(function(a, b) {
                        var rowA = $(a);
                        var rowB = $(b);

                        // Pontuação para cada linha
                        var scoreA = calculateScore(rowA, curso, disciplina, turno, nomeProfessor);
                        var scoreB = calculateScore(rowB, curso, disciplina, turno, nomeProfessor);

                        return scoreB - scoreA; // Ordem decrescente
                    });

                    // Reposicionar as linhas na tabela
                    var $tbody = $('.table tbody');
                    $tbody.empty();
                    $(rows).each(function(index, row) {
                        $tbody.append(row);
                    });
                }

                function calculateScore(row, curso, disciplina, turno, nomeProfessor) {
                    var score = 0;
                    var rowCurso = row.find('td:eq(1)').text().trim().toLowerCase();
                    var rowDisciplina = row.find('td:eq(0)').text().trim().toLowerCase();
                    var rowTurno = row.find('td:eq(2)').text().trim().toLowerCase();
                    var rowProfessor = row.find('td:eq(3)').text().trim().toLowerCase();

                    if (curso && rowCurso.includes(curso)) score += 1;
                    if (disciplina && rowDisciplina.includes(disciplina)) score += 1;
                    if (turno && rowTurno.includes(turno)) score += 1;
                    if (nomeProfessor && rowProfessor.includes(nomeProfessor)) score += 1;

                    return score;
                }
            });
        });
    </script>
</x-layout>

<style>
    /* Estilos para desktop (telas grandes) */
    @media (min-width: 992px) {
        .col-lg-6 #calendar {
            margin-top: -85px;
        }
    }

    /* Ajustes para tablets */
    @media (max-width: 991px) {
        .input-group-outline {
            width: 100% !important;
        }

        .ps-4 {
            padding-left: 1rem !important;
        }

        /* Remove a margem negativa em telas menores */
        .col-sm-6[style*="margin-left"] {
            margin-left: 0 !important;
        }
    }

    /* Ajustes para mobile */
    @media (max-width: 576px) {
        .container-fluid {
            padding: 1rem;
        }

        .table-responsive {
            font-size: 0.8em;
        }

        .input-group-outline {
            margin-bottom: 1rem;
        }

        /* Remove a margem negativa em mobile */
        .col-sm-6[style*="margin-left"] {
            margin-left: 0 !important;
        }
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #4CAF50;
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .btn-close {
        color: white;
    }

    .modal-footer {
        border-top: none;
    }

    .input-group-outline {
        width: 100% !important;
    }

    .btn-outline-white {
        border: 2px solid white !important;
        color: white !important;
    }

    .btn-outline-white:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .modal-header {
        border-radius: 10px 10px 0 0;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: white;
        /* Texto branco */
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 1s;
        animation: fadein 0.5s, fadeout 0.5s 1s;
    }

    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: white;
        /* Texto branco */
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2s;
        animation: fadein 0.5s, fadeout 0.5s 2s;
    }

    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    /* Ajustes de responsividade */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 0.5rem !important;
        }

        .card-header {
            padding: 0.5rem !important;
        }

        .btn {
            padding: 0.5rem !important;
            font-size: 0.8rem !important;
        }

        .material-icons {
            font-size: 18px !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        /* Ajusta o espaçamento dos botões em mobile */
        .d-flex.flex-column.flex-md-row {
            width: 100%;
        }

        /* Centraliza os botões em telas pequenas */
        .d-flex.flex-column.flex-md-row.gap-2 {
            align-items: stretch;
        }

        /* Ajusta a largura dos botões em mobile */
        .btn-outline-white {
            width: 100%;
            margin-right: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ajusta o modal de filtros para mobile */
        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        /* Ajusta a tabela para mobile */
        .table-responsive {
            margin: 0 -0.5rem;
        }

        .table td,
        .table th {
            padding: 0.5rem !important;
            font-size: 0.8rem !important;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn .material-icons {
            margin-right: 0;
        }

        .btn span {
            display: none;
        }
    }

    /* Ajustes para tablets */
    @media (min-width: 769px) and (max-width: 991px) {
        .container-fluid {
            padding: 1rem !important;
        }

        .btn {
            padding: 0.6rem !important;
        }

        .gap-2 {
            gap: 0.8rem !important;
        }
    }

    /* Mantém o espaçamento original em desktops */
    @media (min-width: 992px) {
        .gap-2 {
            gap: 1rem !important;
        }
    }

    /* Adicione ao seu arquivo CSS ou na seção <style> */
    :root {
        --fc-border-color: #e5e7eb;
        --fc-button-bg-color: #4CAF50;
        --fc-button-border-color: #4CAF50;
        --fc-button-hover-bg-color: #45a049;
        --fc-button-hover-border-color: #45a049;
        --fc-button-active-bg-color: #45a049;
    }

    .fc {
        font-family: 'Poppins', sans-serif;
        border-radius: 15px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        background: white;
        padding: 15px;
    }

    .fc .fc-toolbar-title {
        font-size: 1.2em;
        font-weight: 600;
        color: #2c3e50;
    }

    .fc .fc-button {
        border-radius: 8px;
        text-transform: uppercase;
        font-weight: 500;
        font-size: 0.9em;
        padding: 8px 15px;
        transition: all 0.3s ease;
    }

    .fc .fc-daygrid-day {
        transition: all 0.2s ease;
    }

    .fc .fc-daygrid-day:hover {
        background-color: #f8f9fa;
    }

    .fc .fc-daygrid-day-number {
        font-size: 1em;
        color: #4a5568;
        padding: 8px;
    }

    .fc .fc-event {
        border-radius: 6px;
        border: none;
        padding: 3px 5px;
        font-size: 0.85em;
        transition: transform 0.2s ease;
    }

    .fc .fc-event:hover {
        transform: scale(1.02);
    }

    .fc .fc-day-today {
        background: #e8f5e9 !important;
    }

    .fc .fc-highlight {
        background: #f0f9ff !important;
    }

    /* Cores personalizadas para eventos */
    .fc-event {
        background-color: #4CAF50 !important;
        border-left: 4px solid #45a049 !important;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .fc .fc-toolbar {
            flex-direction: column;
            gap: 10px;
        }

        .fc .fc-toolbar-title {
            font-size: 1.1em;
        }
    }
</style>

<script>
    window.onload = function() {
        var snackbar = document.getElementById("snackbar");
        if (snackbar) {
            snackbar.className = "show";
            setTimeout(function() {
                snackbar.className = snackbar.className.replace("show", "");
            }, 1500);
        }
    }
</script>

<!-- Modal de Alunos Confirmados -->
<div class="modal fade" id="alunosConfirmadosModal" tabindex="-1" aria-labelledby="alunosConfirmadosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="alunosConfirmadosModalLabel">Alunos Confirmados</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="listaAlunosConfirmados">
                    <!-- Lista será preenchida via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Adicione este script no final do arquivo -->
<script>
    $(document).ready(function() {
        // Confirmar permanência
        $('.confirmar-permanencia').on('click', function() {
            const button = $(this);
            const permanenciaId = button.data('id');

            button.prop('disabled', true);

            $.ajax({
                url: '{{ route('confirmar_permanencia') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    permanencia_id: permanenciaId
                },
                success: function(response) {
                    if (response.success) {
                        // Atualiza o botão para mostrar confirmado
                        button.removeClass('bg-gradient-info')
                            .addClass('bg-gradient-success')
                            .html('<i class="material-icons">check_circle</i> Confirmado')
                            .prop('disabled', true);

                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Presença confirmada com sucesso!'
                        });
                    } else {
                        button.prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.message || 'Erro ao confirmar presença.'
                        });
                    }
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    console.error('Erro na requisição:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro ao confirmar presença. Por favor, tente novamente.'
                    });
                }
            });
        });

        // Ver alunos confirmados
        $('.ver-confirmados').on('click', function() {
            const permanenciaId = $(this).data('id');

            $.ajax({
                url: '{{ route('listar_confirmados') }}',
                method: 'GET',
                data: {
                    permanencia_id: permanenciaId
                },
                success: function(response) {
                    let html = '<ul class="list-group">';
                    if (response.alunos.length > 0) {
                        response.alunos.forEach(aluno => {
                            html += `
                            <li class="list-group-item">
                                <h6 class="mb-0">${aluno.nome}</h6>
                                <small class="text-muted">Email: ${aluno.email}</small><br>
                                <small class="text-muted">Curso: ${aluno.curso}</small>
                            </li>
                        `;
                        });
                    } else {
                        html +=
                            '<li class="list-group-item">Nenhum aluno confirmou presença ainda.</li>';
                    }
                    html += '</ul>';
                    $('#listaAlunosConfirmados').html(html);
                },
                error: function() {
                    alert('Erro ao carregar lista de alunos confirmados.');
                }
            });
        });
    });
</script>
