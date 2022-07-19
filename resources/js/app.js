require('./bootstrap');

import Notyf from "./plugins/notyf";
import Swal from "./plugins/sweetalert2"

window.swalDeleteConfirmation = function(url)
{
    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja deletar esse registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(url)
                .then(function () {
                    Swal.fire(
                        'Deletado!',
                        'Registro deletado com sucesso.',
                        'success'
                    ).then(() => {
                        //atualiza a view para remover o dado que foi excluido
                        window.location.assign(window.location)
                    })
                })
                .catch(function () {
                    Swal.fire(
                        'Erro!',
                        'Nao foi possivel deletar o registro.',
                        'error'
                    )
                });
        }
    })
}

window.notificarSucesso = function (descricao) {
    Notyf.success(descricao);
}


