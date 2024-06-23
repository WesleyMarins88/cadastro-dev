@extends('layouts.layout')

@section('title', 'Níveis')

@section('content')
<h2 class="mb-4">Lista de Níveis</h2>
<button class="btn btn-success mb-3" id="addNivelBtn">Adicionar Nível</button>
<table id="nivelTable" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nível</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>



<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Adicionar/Editar Nível</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="nivel" class="form-label">Nível</label>
                        <input type="text" class="form-control" id="nivel" name="nivel" required>
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
    $('#nivelTable').DataTable({
        ajax: {
            url: 'http://127.0.0.1:8000/api/niveis',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nivel' },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-nivel="${row.nivel}">Editar</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Deletar</button>
                    `;
                }
            }
        ]
    });

    $('#addNivelBtn').on('click', function() {
        $('#editModalLabel').text('Adicionar Nível');
        $('#editForm').data('id', '');
        $('#nivel').val('');
        $('#editModal').modal('show');
    });

    $('#nivelTable tbody').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const nivel = $(this).data('nivel');
        $('#editModalLabel').text('Editar Nível');
        $('#editForm').data('id', id);
        $('#nivel').val(nivel);
        $('#editModal').modal('show');
    });

    $('#nivelTable tbody').on('click', '.delete-btn', function() {
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
                    url: `http://127.0.0.1:8000/api/niveis/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire(
                            'Deletado!',
                            'O nível foi deletado.',
                            'success'
                        );
                        $('#nivelTable').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nivel = $('#nivel').val();
        const method = id ? 'PUT' : 'POST';
        const url = id ? `http://127.0.0.1:8000/api/niveis/${id}` : 'http://127.0.0.1:8000/api/niveis';
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify({ nivel: nivel }),
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire(
                    'Salvo!',
                    `O nível foi ${id ? 'editado' : 'adicionado'} com sucesso.`,
                    'success'
                );
                $('#nivelTable').DataTable().ajax.reload();
            }
        });
    });
});
</script>
@endsection
