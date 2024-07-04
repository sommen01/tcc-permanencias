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
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST"
                                        action="{{ route('permanencias.update', $permanencia->id) }}"
                                        enctype="multipart/form-data" class="text-start">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" name="foto" id="foto">
                                            <img src="{{ Storage::url($permanencia->foto) }}" alt="Foto"
                                                width="100">
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
                                            <label for="email_do_professor" class="form-label">Email do
                                                Professor</label>
                                            <input type="email" class="form-control" name="email_do_professor"
                                                id="email_do_professor" value="{{ $permanencia->email_do_professor }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nome_do_professor" class="form-label">Nome do Professor</label>
                                            <input type="text" class="form-control" name="nome_do_professor"
                                                id="nome_do_professor" value="{{ $permanencia->nome_do_professor }}"
                                                required>
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
                                            <label for="data" class="form-label">Data</label>
                                            <input type="date" class="form-control" name="data" id="data"
                                                value="{{ $permanencia->data }}" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2 btn-no-hover">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</x-layout>
