@extends('admin.layout')
@section("content")
<div class="col-12">
    <div class="box">

    <div class="box-body wizard-content">
    <form action="{{ route('admin.cupom.save') }}" method="post" class="tab-wizard wizard-circle">
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Plano</label>
                        <input type="text" name="plano" class="form-control" value="" id="" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Valor do Plano (Mensalidade)</label>
                        <input type="text" name="valor" class="form-control" value="" id="" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Valor da Joia</label>
                        <input type="text" name="joia" class="form-control" value="" id="" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="submit" value="Salvar" class="btn btn-success">
            </div>
        </section>
    </form>
    </div>

    <div class="table-responsive">
            <table id="tabela-associado" class="datatable table table-bordered table-hover table-striped display nowrap margin-top-10 w-p100">
            <thead>
                <tr>
                    <th>Plano</th>
                    <th>Mensalidade</th>
                    <th>Jóia</th>
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
        ]

        dataTableOptions.ajax = $.fn.dataTable.pipeline( {
            url: "{{ route('admin.cadastro.ajax.planos') }}",
            type : 'POST',
            pages: 1,
            data: function ( d ) {
                d.extra_search = $('#extra').val();
            },
        })

        var table = $(".datatable").DataTable(dataTableOptions); // End of use strict
        })



	</script>
    <script src="{{ asset('js/cadastro/planos.js') }}?v={{ time() }}"></script>
@endsection
