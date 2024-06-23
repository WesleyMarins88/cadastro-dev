@extends('layouts.layout')

@section('title', 'Desenvolvedores')

@section('content')
<h2 class="mb-4">Lista de Desenvolvedores</h2>
<button class="btn btn-success mb-3" id="addDevBtn">Adicionar Desenvolvedor</button>
<div class="table-responsive">
    <table id="desenvolvedorTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Data de Nascimento</th>
                <th>Idade</th>
                <th>Hobby</th>
                <th>Nível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Adicionar/Editar Desenvolvedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <input type="text" class="form-control" id="sexo" name="sexo" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>
                    <div class="mb-3">
                        <label for="hobby" class="form-label">Hobby</label>
                        <input type="text" class="form-control" id="hobby" name="hobby" required>
                    </div>
                    <div class="mb-3">
                        <label for="nivel_id" class="form-label">Nível</label>
                        <select class="form-control" id="nivel_id" name="nivel_id" required>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#desenvolvedorTable').DataTable({
        ajax: {
            url: 'http://127.0.0.1:8000/api/desenvolvedores',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nome' },
            { data: 'sexo' },
            { data: 'data_nascimento' },
            { data: 'idade' },
            { data: 'hobby' },
            { data: 'nivel.nivel' },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-nome="${row.nome}" data-sexo="${row.sexo}" data-data_nascimento="${row.data_nascimento}" data-hobby="${row.hobby}" data-nivel_id="${row.nivel.id}">Editar</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Deletar</button>
                    `;
                }
            }
        ]
    });

    $.ajax({
        url: 'http://127.0.0.1:8000/api/niveis',
        type: 'GET',
        success: function(data) {
            data.forEach(function(nivel) {
                $('#nivel_id').append(new Option(nivel.nivel, nivel.id));
            });
        }
    });

    $('#addDevBtn').on('click', function() {
        $('#editModalLabel').text('Adicionar Desenvolvedor');
        $('#editForm').data('id', '');
        $('#nome').val('');
        $('#sexo').val('');
        $('#data_nascimento').val('');
        $('#hobby').val('');
        $('#nivel_id').val('');
        $('#editModal').modal('show');
    });

    $('#desenvolvedorTable tbody').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const nome = $(this).data('nome');
        const sexo = $(this).data('sexo');
        const data_nascimento = $(this).data('data_nascimento');
        const hobby = $(this).data('hobby');
        const nivel_id = $(this).data('nivel_id');
        $('#editModalLabel').text('Editar Desenvolvedor');
        $('#editForm').data('id', id);
        $('#nome').val(nome);
        $('#sexo').val(sexo);
        $('#data_nascimento').val(data_nascimento);
        $('#hobby').val(hobby);
        $('#nivel_id').val(nivel_id);
        $('#editModal').modal('show');
    });

    $('#desenvolvedorTable tbody').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `http://127.0.0.1:8000/api/desenvolvedores/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire(
                            'Deletado!',
                            'O desenvolvedor foi deletado.',
                            'success'
                        );
                        $('#desenvolvedorTable').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nome = $('#nome').val();
        const sexo = $('#sexo').val();
        const data_nascimento = $('#data_nascimento').val();
        const hobby = $('#hobby').val();
        const nivel_id = $('#nivel_id').val();
        const method = id ? 'PUT' : 'POST';
        const url = id ? `http://127.0.0.1:8000/api/desenvolvedores/${id}` : 'http://127.0.0.1:8000/api/desenvolvedores';
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify({
                nivel_id: nivel_id,
                nome: nome,
                sexo: sexo,
                data_nascimento: data_nascimento,
                hobby: hobby
            }),
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire(
                    'Salvo!',
                    `O desenvolvedor foi ${id ? 'editado' : 'adicionado'} com sucesso.`,
                    'success'
                );
                $('#desenvolvedorTable').DataTable().ajax.reload();
            }
        });
    });
}); 
</script>
@endsection
