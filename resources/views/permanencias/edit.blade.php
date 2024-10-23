<x-layout bodyClass="bg-gray-200">
    <style>
        .google-btn {
            display: flex;
            align-items: center;
            background-color: #4285F4;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
        }

        .google-btn:hover {
            background-color: #357ae8;
            color: white;
            text-decoration: none;
        }

        .google-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .fa-google {
            color: red;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-outline select {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
            padding: 0.375rem 0;
        }

        .input-group-outline select:focus {
            border-bottom: 2px solid #80bdff;
            box-shadow: none;
        }
    </style>

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <!-- <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://jcconcursos.com.br/media/_versions/noticia/ifms_widelg.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container mt-5">
                <div class="row signin-margin">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom card-color-custom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Editar Permanência
                                    </h4>

                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST"
                                        action="{{ route('permanencias.update', $permanencia->id) }}"
                                        class="text-start">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="dia_semana" class="form-label">Dia da Semana</label>
                                            <div class="input-group input-group-outline">
                                                <select class="form-control" name="dia_semana" id="dia_semana" required>
                                                    <option value="1"
                                                        {{ $permanencia->dia_semana == 1 ? 'selected' : '' }}>
                                                        Segunda-feira</option>
                                                    <option value="2"
                                                        {{ $permanencia->dia_semana == 2 ? 'selected' : '' }}>
                                                        Terça-feira</option>
                                                    <option value="3"
                                                        {{ $permanencia->dia_semana == 3 ? 'selected' : '' }}>
                                                        Quarta-feira</option>
                                                    <option value="4"
                                                        {{ $permanencia->dia_semana == 4 ? 'selected' : '' }}>
                                                        Quinta-feira</option>
                                                    <option value="5"
                                                        {{ $permanencia->dia_semana == 5 ? 'selected' : '' }}>
                                                        Sexta-feira</option>
                                                    <option value="6"
                                                        {{ $permanencia->dia_semana == 6 ? 'selected' : '' }}>Sábado
                                                    </option>
                                                    <option value="7"
                                                        {{ $permanencia->dia_semana == 7 ? 'selected' : '' }}>Domingo
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hora_inicio" class="form-label">Hora de Início</label>
                                            <input type="time" class="form-control" name="hora_inicio"
                                                id="hora_inicio" value="{{ $permanencia->hora_inicio }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hora_fim" class="form-label">Hora de Término</label>
                                            <input type="time" class="form-control" name="hora_fim" id="hora_fim"
                                                value="{{ $permanencia->hora_fim }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="disciplina" class="form-label">Disciplina</label>
                                            <div class="input-group input-group-outline">
                                                <select class="form-control" name="disciplina" id="disciplina" required>
                                                    <option value="Matemática"
                                                        {{ $permanencia->disciplina == 'Matemática' ? 'selected' : '' }}>
                                                        Matemática</option>
                                                    <option value="Português"
                                                        {{ $permanencia->disciplina == 'Português' ? 'selected' : '' }}>
                                                        Português</option>
                                                    <option value="História"
                                                        {{ $permanencia->disciplina == 'História' ? 'selected' : '' }}>
                                                        História</option>
                                                    <option value="Geografia"
                                                        {{ $permanencia->disciplina == 'Geografia' ? 'selected' : '' }}>
                                                        Geografia</option>
                                                    <option value="Biologia"
                                                        {{ $permanencia->disciplina == 'Biologia' ? 'selected' : '' }}>
                                                        Biologia</option>
                                                    <option value="Física"
                                                        {{ $permanencia->disciplina == 'Física' ? 'selected' : '' }}>
                                                        Física</option>
                                                    <option value="Química"
                                                        {{ $permanencia->disciplina == 'Química' ? 'selected' : '' }}>
                                                        Química</option>
                                                    <option value="Inglês"
                                                        {{ $permanencia->disciplina == 'Inglês' ? 'selected' : '' }}>
                                                        Inglês</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="curso" class="form-label">Curso</label>
                                            <div class="input-group input-group-outline">
                                                <select class="form-control" name="curso" id="curso" required>
                                                    <option value="Informática"
                                                        {{ $permanencia->curso == 'Informática' ? 'selected' : '' }}>
                                                        Informática</option>
                                                    <option value="Mecânica"
                                                        {{ $permanencia->curso == 'Mecânica' ? 'selected' : '' }}>
                                                        Mecânica</option>
                                                    <option value="Eletrotécnica"
                                                        {{ $permanencia->curso == 'Eletrotécnica' ? 'selected' : '' }}>
                                                        Eletrotécnica</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="turno" class="form-label">Turno</label>
                                            <div class="input-group input-group-outline">
                                                <select class="form-control" name="turno" id="turno" required>
                                                    <option value="Matutino"
                                                        {{ $permanencia->turno == 'Matutino' ? 'selected' : '' }}>
                                                        Matutino</option>
                                                    <option value="Vespertino"
                                                        {{ $permanencia->turno == 'Vespertino' ? 'selected' : '' }}>
                                                        Vespertino</option>
                                                    <option value="Noturno"
                                                        {{ $permanencia->turno == 'Noturno' ? 'selected' : '' }}>
                                                        Noturno</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="professor_id" class="form-label">Nome do Professor</label>
                                            <div class="input-group input-group-outline">
                                                <select class="form-control" name="professor_id" id="professor_id"
                                                    required>
                                                    <option value="">Selecione um professor</option>
                                                    @foreach ($professores as $professor)
                                                        <option value="{{ $professor->id }}"
                                                            data-email="{{ $professor->email }}"
                                                            {{ $permanencia->professor_id == $professor->id ? 'selected' : '' }}>
                                                            {{ $professor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_do_professor" class="form-label">Email do
                                                Professor</label>
                                            <input type="email" class="form-control" name="email_do_professor"
                                                id="email_do_professor"
                                                value="{{ $permanencia->email_do_professor }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="1" {{ $permanencia->status ? 'selected' : '' }}>
                                                    Ativo</option>
                                                <option value="0" {{ !$permanencia->status ? 'selected' : '' }}>
                                                    Inativo</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="duracao">Duração</label>
                                            <select name="duracao" id="duracao" class="form-control" required>
                                                <option value="unica"
                                                    {{ $permanencia->duracao == 'unica' ? 'selected' : '' }}>Única vez
                                                </option>
                                                <option value="semestre"
                                                    {{ $permanencia->duracao == 'semestre' ? 'selected' : '' }}>
                                                    Semestre (6 meses)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="sala" class="form-label">Sala</label>
                                            <input type="text" class="form-control" name="sala" id="sala"
                                                value="{{ $permanencia->sala }}">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2 btn-no-hover">Salvar</button>
                                        </div>
                                        <div class="text-center">
                                            <a href="javascript:history.back()"
                                                class="btn bg-gradient-secondary w-100 my-2">Voltar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const professorSelect = document.getElementById('professor_id');
            const emailInput = document.getElementById('email_do_professor');

            function updateEmailField() {
                const selectedOption = professorSelect.options[professorSelect.selectedIndex];
                emailInput.value = selectedOption.getAttribute('data-email') || '';
            }

            professorSelect.addEventListener('change', updateEmailField);

            // Preencha o campo de email inicialmente
            updateEmailField();
        });
    </script>
</x-layout>
