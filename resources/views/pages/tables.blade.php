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
                                <a href="{{ route('permanencias.create') }}"
                                    class="btn btn-light text-primary me-3">Cadastrar Permanência</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <form action="{{ route('enviar.confirmacao') }}" method="POST">
                                    @csrf
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Foto</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nome</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Email</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Data</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Confirmar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permanencias as $permanencia)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                <img src="{{ Storage::url($permanencia->foto) }}"
                                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                                    alt="user">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $permanencia->nome }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $permanencia->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $permanencia->nome }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs text-secondary mb-0">{{ $permanencia->email }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($permanencia->status)
                                                            <span
                                                                class="badge badge-sm bg-gradient-success">Disponível</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">Indisponível</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($permanencia->data)->format('d/m/Y') }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <input type="checkbox" name="permanencias[]"
                                                            value="{{ $permanencia->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-3">Enviar Email de
                                        Confirmação</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
