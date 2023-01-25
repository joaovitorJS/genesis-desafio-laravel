@extends('layouts.app')

@section('content')
<main class="container my-4">
  <div class="col-9 mx-auto">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="m-0">Atualizar agendamento</h2>
    </div>

    <div class="mt-4">
      <div class="alert alert-danger d-none message-box" role="alert"></div>
      <form autocomplete="off" name="form-scheduling">
        {{-- CSRF - token de segurança para validar o formulário --}}
        @csrf

        <input type="text" class="d-none" name="id" id="id" value="{{ $scheduling->id }}" />

        <div class="mb-3">
          <label class="form-label" for="name">Nome</label>
          <input class="form-control" type="text" name="name" id="name" value="{{ $scheduling->name }}" />
          <span class=" name-error error-text text-danger"></span>
        </div>

        <div class="row mb-3">
          <div class="col-12 mb-3 mb-md-0 col-md-6">
            <label class="form-label" for="cpf">CPF</label>
            <input class="form-control" type="text" name="cpf" id="cpf" value="{{ $scheduling->cpf }}" />
            <span class="cpf-error error-text text-danger"></span>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="card_sus">Cartão SUS</label>
            <input class="form-control" type="text" name="card_sus" id="card_sus" value="{{ $scheduling->card_sus }}" />
            <span class="card_sus-error error-text text-danger"></span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="reason">Motivo do atendimento</label>
          <input class="form-control" type="text" name="reason" id="reason" value="{{ $scheduling->reason }}" />
          <span class="reason-error error-text text-danger"></span>
        </div>

        <div class="row mb-3">
          <div class="col-12 mb-3 mb-md-0 col-md-6">
            <label class="form-label" for="date_scheduling">Data do atendimento</label>
            <input class="form-control" type="datetime-local" name="date_scheduling" id="date_scheduling"
              value="{{ $scheduling->date_scheduling }}" />
            <span class="date_scheduling-error error-text text-danger"></span>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="urgency">Urgência do atendimento</label>
            <select class="form-select" name="urgency" id="urgency">
              <option value="baixa">Baixa</option>
              <option value="media">Média</option>
              <option value="alta">Alta</option>
              <option value="urgente">Urgente</option>
            </select>
            <span class="urgency-error error-text text-danger"></span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="doctor_name">Médico atendente</label>
          <input class="form-control" type="text" name="doctor_name" id="doctor_name"
            value="{{ $scheduling->doctor_name }}" />
          <span class="doctor_name-error error-text text-danger"></span>
        </div>

        <div class="mb-3">
          <label class="form-label" for="professional_name">Nome do Profissional</label>
          <input class="form-control" type="text" name="professional_name" id="professional_name"
            value="{{ $scheduling->professional_name }}" />
          <span class="professional_name-error error-text text-danger"></span>
        </div>

        <div class="row mx-0 mt-4 justify-content-end align-items-center">
          <a href="/" class="btn btn-danger col-4 col-md-3 col-lg-2">
            Cancelar
          </a>
          <button type=" submit" class="ml-2 btn btn-success col-4 col-md-3 col-lg-2">
            Salvar
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
@endsection

@push('scripts')
{{-- Import do momentjs para manipular datas --}}
<script src="https://momentjs.com/downloads/moment.min.js"></script>
<script>
  /*Redirecionar para lista de agendamentos*/
  function redirectToSchedulesList(message) {
    window.location.href = "/"
  }

  /*Limpa os aviso de erros do formulário*/
  function clearFormErrors() {
    $(document).find('span.error-text').text('');
    $(document).find('input').removeClass('is-invalid');
    $(document).find('select').removeClass('is-invalid');
  }

  function addMaskInCPFInput() {
    $('input[name="cpf"]').on('input', function (event) {
      var cpf = $(this).val();
      $(this).val(cpfFormatter(cpf));
    });
  }

  function addMaskInCardSUSInput() {
    $('input[name="card_sus"]').on('input', function (event) {
      var cardSUS = $(this).val();
      $(this).val(cardSUSFormatter(cardSUS));
    });
  }

  /*Mostra os erros no formulário*/
  function showErrorsInForm(err) {
    var errors = err.responseJSON.errors
    $.each(errors, function(key, value) {
      var selector = 'span.' + key + '-error'
      $(selector).text(value[0])
      $('#'+key).addClass('is-invalid')
    })
  }
 

  $(function() {
    /*Adicionando formatação para o input CPF*/
    var cpf = $('input#cpf').val();
    $('input#cpf').val(cpfFormatter(cpf));
    var cardSUS = $('input#card_sus').val();
    $('input#card_sus').val(cardSUSFormatter(cardSUS));

    /*Adicionando minimo para o input daatetime-local*/
    var dateNow = new Date();
    var dateFormatted = moment(dateNow).format('YYYY-MM-DD[T]HH:mm');
    $('input[type="datetime-local"]').attr('min', dateFormatted);

    /*Setando value no select*/
    var valueOptionSelect = "{{ $scheduling->urgency }}";
    $('select#urgency option[value='+valueOptionSelect+']').attr('selected', 'selected');

     /*Mascaras*/
     addMaskInCPFInput();
     addMaskInCardSUSInput();

    /*Capturando evento de submit do formulário*/
    $('form[name="form-scheduling"]')
      .submit(function(event) {
          event.preventDefault();

          /*Formatando o cpf e cartão sus para enviar*/
          var valueCPF = $(this).find('input[name="cpf"]').val();
          var cpfToSend = valueCPF.replace(/\D/g, "");
          var valueCardSUS = $(this).find('input[name="card_sus"]').val();
          var cardSUSToSend = valueCardSUS.replace(/\D/g, "");

          var data = $(this).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
          }, {});

          var dataFormatted = {
            ...data,
            cpf: cpfToSend,
            card_sus: cardSUSToSend,
          }

          $.ajax({
            url: "{{ route('schedules.update', $scheduling->id) }}",
            type: "PUT",
            data: dataFormatted,
            dataType: "JSON",
            beforeSend: function() {
              clearFormErrors();
            },
            success: function(response) {
              if (response.success === true) {
                redirectToSchedulesList(response.message)
              } else {
                /* Informa o erro*/
                $('.message-box').removeClass('d-none').html(response.message)
              }
            },
            error: function(err) {
              if(err.status === 422) { /*A validação disparou o erro 422*/
                showErrorsInForm(err);
              }
            } 
          })
        
      })
  })
</script>
@endpush