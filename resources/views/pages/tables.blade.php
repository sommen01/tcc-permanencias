<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Permanências"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3">Permanências</h6>
                                @if (auth()->user()->role === 'professor')
                                    <a href="{{ route('permanencias.create') }}"
                                        class="btn btn-light text-primary me-3">Cadastrar Permanência</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <!-- Formulário de Filtros -->
                                <h6 class=" text-capitalize ps-4">Filtros</h6>

                                <div class="row mb-4 ps-4">
                                    <!-- Primeira linha -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline" style="width: 50%">
                                                <select class="form-control filter-select" name="curso"
                                                    id="curso">
                                                    <option value="">Curso</option>
                                                    <option value="Informática">Informática</option>
                                                    <option value="Mecânica">Mecânica</option>
                                                    <option value="Eletrotécnica">Eletrotécnica</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-left: -610px">
                                            <div class="input-group input-group-outline" style="width: 50%">
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
                                    </div>

                                    <!-- Segunda linha -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline" style="width: 50%">
                                                <select class="form-control filter-select" name="turno"
                                                    id="turno">
                                                    <option value="">Turno</option>
                                                    <option value="Matutino">Matutino</option>
                                                    <option value="Vespertino">Vespertino</option>
                                                    <option value="Noturno">Noturno</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-left: -610px">
                                            <div class="input-group input-group-outline" style="width: 50%">
                                                <select class="form-control filter-select" name="nome_do_professor"
                                                    id="nome_do_professor">
                                                    <option value="">Nome do Professor</option>
                                                    @foreach ($professores as $professor)
                                                        <option value="{{ $professor->name }}">{{ $professor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conteúdo Principal (Tabela + Calendário) -->
                                <div class="row">
                                    <!-- Coluna da Tabela -->
                                    <div class="col-md-6 ps-4">
                                        <div class="table-responsive" style="font-size: 0.9em;">
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
                                                        @if (Auth::user()->hasRole('professor'))
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Ações</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($permanencias as $permanencia)
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
                                                            @if (Auth::user()->hasRole('professor'))
                                                                <td class="align-middle text-center">
                                                                    @if ($permanencia->professor_id == Auth::id())
                                                                        <a href="{{ route('permanencias.edit', $permanencia->id) }}"
                                                                            class="btn btn-info btn-sm">Editar</a>
                                                                        <button
                                                                            class="btn btn-danger btn-sm excluir-permanencia"
                                                                            data-id="{{ $permanencia->id }}">Excluir</button>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Coluna do Calendário -->
                                    @if (Auth::user()->hasRole('aluno'))
                                        <div class="col-md-6">
                                            <div class="card" style="margin-top: -150px;">

                                                <div class="card-body">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                                                <p><strong>Horário Inicial:</strong> <span
                                                        id="modalHorarioInicial"></span>
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

            function generateRecurringEvents(permanencias) {
                var events = [];
                var today = new Date();
                var sixMonthsLater = new Date(today.getFullYear(), today.getMonth() + 6, today.getDate());

                permanencias.forEach(function(permanencia) {
                    var startDate = new Date(permanencia.data);
                    var endDate = permanencia.duracao === 'semestre' ? sixMonthsLater : new Date(startDate);

                    while (startDate <= endDate) {
                        events.push({
                            id: permanencia.id,
                            title: permanencia.disciplina + ' - ' + permanencia.nome_do_professor,
                            start: new Date(startDate),
                            extendedProps: {
                                disciplina: permanencia.disciplina,
                                curso: permanencia.curso,
                                turno: permanencia.turno,
                                nome_do_professor: permanencia.nome_do_professor,
                                email_do_professor: permanencia.email_do_professor,
                                status: permanencia.status,
                                duracao: permanencia.duracao,
                                sala: permanencia.sala,
                                hora_inicio: permanencia.hora_inicio,
                                hora_fim: permanencia.hora_fim
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

            document.querySelectorAll('.excluir-permanencia').forEach(function(button) {
                button.addEventListener('click', function() {
                    var permanenciaId = this.getAttribute('data-id');
                    var button = this;

                    if (confirm('Tem certeza que deseja excluir esta permanência?')) {
                        fetch('{{ route('excluir_permanencia') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    permanencia_id: permanenciaId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Permanência excluída com sucesso!');
                                    button.closest('tr').remove();
                                } else {
                                    alert('Erro ao excluir permanência: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                                alert(
                                    'Erro ao excluir permanência. Por favor, tente novamente.'
                                );
                            });
                    }
                });
            });

            $(document).ready(function() {
                var $table = $('.table');
                var $tbody = $table.find('tbody');
                var originalRows = $('.permanencia-row').get();

                $('.filter-select').on('change', function() {
                    filterTable();
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
