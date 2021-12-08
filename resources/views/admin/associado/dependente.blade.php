@extends('admin.layout')
@section("content")
<div class="col-12">
    <div class="box">

    <!-- /.box-header -->
    <div class="box-body"><br>

    <div class="table-responsive">
            <table id="tabela-cupom" class="datatable table table-bordered table-hover table-striped display nowrap margin-top-10 w-p100">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Titular</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Parentesco</th>
                    <th>Data Cadastro</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        </div>
    </div>


    </div>
</div>
@endsection
@section("scriptjs")
    <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatable.config.js') }}"></script>
    <script>
		$(function () {
        "use strict";

        dataTableOptions.processing = true
        dataTableOptions.serverSide = true;
        dataTableOptions.searchable = false;
        dataTableOptions.columns = [
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
            {"orderable": false},
        ]

        dataTableOptions.ajax = $.fn.dataTable.pipeline( {
            url: "{{ route('admin.associado.ajax.dependentes') }}",
            type : 'POST',
            pages: 1,
            data: function ( d ) {
                d.extra_search = $('#extra').val();
            },
        })

        var table = $(".datatable").DataTable(dataTableOptions); // End of use strict
        })

        let url ='{{ route("admin.associado.ajax.detalhes", ["idassociado" => ":pidassociado"]) }}';

	</script>
    <script src="{{ asset('js/associado/index.js') }}?v={{ time() }}"></script>
@endsection
