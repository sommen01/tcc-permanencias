<x-layout bodyClass="bg-gray-200">
    <style>
        .institutional-btn {
            display: flex;
            align-items: center;
            background-color: rgb(38, 147, 170);
            color: white;
            padding: 20px 24px;
            width: 90%;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .institutional-btn:hover {
            background-color: #357ae8;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
            width: 100%;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
        }

        .info-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            width: 100%;
            margin: 0 auto;
        }

        .info-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
        }

        .info-title {
            font-size: 1.2rem;
            color: #344767;
            margin-bottom: 10px;
        }

        .info-text {
            font-size: 0.9rem;
            color: #7b809a;
        }

        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 700px;
                gap: 20px;
            }
        }

        @media (max-width: 576px) {
            .info-grid {
                grid-template-columns: 1fr;
                max-width: 350px;
            }

            .info-card {
                max-width: 100%;
            }
        }

        .card-color-custom {
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header img {
            padding: 0 8px;
        }

        .snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
        }

        .snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
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
    </style>

    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://jcconcursos.com.br/media/_versions/noticia/ifms_widelg.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <!-- Card de Login -->
                <div class="row signin-margin justify-content-center w-100">
                    <div class="col-lg-4 col-md-8 col-12">
                        <div class="card z-index-0 fadeIn3 fadeInBottom card-color-custom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="py-3 pe-1">
                                    <h4 class="text-green font-weight-bolder text-center mt-2 mb-0">SCP - Sistema
                                        de Consulta de Permanência </h4>
                                    <img src="{{ asset('assets/img/logo-ifms.png') }}"
                                        style="width: 100%; height: auto;" />

                                    <div class="row mt-4 mb-3 justify-content-center">
                                        <a href="{{ route('login.google') }}" class="institutional-btn">
                                            <i class="fab fa-google google-icon"></i>
                                            Logar com sua conta institucional
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid de Informações -->
                <div class="info-grid">
                    <div class="info-card">
                        <img src="{{ asset('assets/gifs/login-.gif') }}" alt="Mapa Mental" class="info-icon">
                        <h3 class="info-title">Acessar</h3>
                        <p class="info-text">Para realizar o login, basta clicar no botão acima e entrar com
                            sua
                            conta institucional.</p>
                    </div>

                    <div class="info-card">
                        <img src="{{ asset('assets/gifs/edit.gif') }}" alt="Guia do Aluno" class="info-icon">
                        <h3 class="info-title">Complete seu perfil</h3>
                        <p class="info-text">No primeiro acesso, você deve completar seu perfil, com informações como
                            semestre, turno e curso.</p>
                    </div>

                    <div class="info-card">
                        <img src="{{ asset('assets/gifs/calendar.gif') }}" alt="Perguntas Frequentes" class="info-icon">
                        <h3 class="info-title">Consultar horários das permanências</h3>
                        <p class="info-text">Acesse a lista de horários das permanências e escolha o que você
                            deseja.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>

    @if (session('snackbar'))
        <div id="snackbar" class="snackbar">
            {{ session('snackbar') }}
        </div>
    @endif
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var snackbar = document.getElementById("snackbar");
        snackbar.className = "snackbar show";
        setTimeout(function() {
            snackbar.className = snackbar.className.replace("show", "");
        }, 3000);
    });
</script>
