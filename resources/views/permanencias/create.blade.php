<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main
        class="main-content position-relative max-height-vh-100 h-100 border-radius-lg d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3">Cadastrar Permanência</h6>
                                <a href="{{ url()->previous() }}" class="btn btn-light text-primary me-3">Voltar</a>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <form action="{{ route('permanencias.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control border border-primary" id="foto"
                                        name="foto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control border border-primary" id="nome"
                                        name="nome" placeholder="Digite o nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control border border-primary" id="email"
                                        name="email" placeholder="Digite o email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select border border-primary" id="status" name="status"
                                        required>
                                        <option value="1">Disponível</option>
                                        <option value="0">Indisponível</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="data" class="form-label">Data</label>
                                    <input type="text" class="form-control border border-primary datepicker"
                                        id="data" name="data" placeholder="Selecione a data" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</x-layout>
