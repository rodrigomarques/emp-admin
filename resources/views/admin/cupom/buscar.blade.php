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
                    <th scope="col">Código</th>
                    <th scope="col">Cupom</th>
                    <th scope="col">Início</th>
                    <th scope="col">Término</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Status</th>
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
            {"orderable": true},
            {"orderable": true},
            {"orderable": true},
            {"orderable": true},
            {"orderable": true},
            {"orderable": false},
            {"orderable": false},
        ]

        dataTableOptions.ajax = $.fn.dataTable.pipeline( {
            url: "{{ route('admin.cupom.ajax.buscar') }}",
            type : 'POST',
            pages: 1,
            data: function ( d ) {
                d.extra_search = $('#extra').val();
            },
        })

        var table = $(".datatable").DataTable(dataTableOptions); // End of use strict
        })
	</script>
@endsection
