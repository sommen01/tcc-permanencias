<!-- resources/views/profile/complete.blade.php -->
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
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Complete seu perfil
                                    </h4>

                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="/complete-profile" class="text-start">
                                        @csrf
                                        <h5 class="text-center mb-4">Informações do Aluno</h5>
                                        <h2>Curso</h2>

                                        <div class="input-group input-group-outline">
                                            <select class="form-control" name="curso" id="curso" required>
                                                <option value="Informática">Informática</option>
                                                <option value="Mecânica">Mecânica</option>
                                                <option value="Eletrotécnica">Eletrotécnica</option>
                                            </select>
                                        </div>
                                        <h2>Período</h2>
                                        <div class="input-group input-group-outline">
                                            <select class="form-control" name="periodo" id="periodo" required>
                                                <option value="Primeiro">Primeiro</option>
                                                <option value="Segundo">Segundo</option>
                                                <option value="Terceiro">Terceiro</option>
                                                <option value="Quarto">Quarto</option>
                                                <option value="Quinto">Quinto</option>
                                                <option value="Sexto">Sexto</option>
                                            </select>
                                        </div>
                                        <h2>Turno</h2>

                                        <div class="input-group input-group-outline">
                                            <select class="form-control" name="turno" id="turno" required>
                                                <option value="Matutino">Matutino</option>
                                                <option value="Vespertino">Vespertino</option>
                                                <option value="Noturno">Noturno</option>
                                            </select>
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
