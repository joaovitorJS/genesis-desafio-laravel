@extends('layouts.app')

@section('content')
<main class="container mt-4 p-0">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="m-0">Agendamentos</h2>
        <a class="btn btn-success" href="{{ route('schedules.create') }}">
            Novo agendamento
        </a>
    </div>
    {{-- Caso não há agendamentos cadastrados --}}
    @if (!isset($schedules) || count($schedules) === 0)
    <strong class="fs-3 d-block mt-4">
        Não há agendamentos cadastrados!
    </strong>
    @else
    <div class="row mt-5 p-0 mx-0">
        <div class="table-responsive px-0">
            <table class="table table-striped table-hover table-light">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Cartão SUS</th>
                        <th scope="col">Motivo do atendimento</th>
                        <th scope="col">Data do atendimento</th>
                        <th scope="col">Urgência do atendimento</th>
                        <th scope="col">Médico atendente</th>
                        <th scope="col">Nome do Profisional</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $scheduling)
                    <tr>
                        <th scope="row">{{ $scheduling->name }}</th>
                        <td name="cpf">{{ $scheduling->cpf }}</td>
                        <td>{{ $scheduling->card_sus }}</td>
                        <td>{{ $scheduling->reason }}</td>
                        <td>{{ $scheduling->date_scheduling }}</td>
                        <td>{{ $scheduling->urgency }}</td>
                        <td>{{ $scheduling->doctor_name }}</td>
                        <td>{{ $scheduling->professional_name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('schedules.edit', $scheduling->id)}}">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</main>
@endsection

@push('styles')
<style>
    .teste {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .header {
        font-size: 2.5rem;
    }
</style>
@endpush


@push('scripts')
<script>
    $(function() {
        /*Adicionando formatação para a coluna CPF*/
        $('td[name="cpf"]').each(function (index) {
            var cpf = $( this ).text();
            $( this ).text(cpfFormatter(cpf));
        });
    });
</script>
@endpush