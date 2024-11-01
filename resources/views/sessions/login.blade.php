<x-layout bodyClass="bg-gray-200">
    <style>
        .institutional-btn {
            display: flex;
            align-items: center;
            background-color: #4285F4;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
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
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">SOHPE - Sistema
                                        Gerenciador de Horários de Permanência</h4>

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
                        <img src="{{ asset('assets/img/mapa-mental.png') }}" alt="Mapa Mental" class="info-icon">
                        <h3 class="info-title">Acessar</h3>
                        <p class="info-text">Para realizar o login, basta clicar no botão acima e entrar com
                            sua
                            conta institucional.</p>
                    </div>

                    <div class="info-card">
                        <img src="{{ asset('assets/img/guia-aluno.png') }}" alt="Guia do Aluno" class="info-icon">
                        <h3 class="info-title">Complete seu perfil</h3>
                        <p class="info-text">No primeiro acesso, você deve completar seu perfil, com informações como
                            semestre, turno e curso.</p>
                    </div>

                    <div class="info-card">
                        <img src="{{ asset('assets/img/faq.png') }}" alt="Perguntas Frequentes" class="info-icon">
                        <h3 class="info-title">Consultar horários das permanências</h3>
                        <p class="info-text">Acesse a lista de horários das permanências e escolha o que você
                            deseja.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>
</x-layout>
