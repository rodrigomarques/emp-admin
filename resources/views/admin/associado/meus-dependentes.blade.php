@extends('admin.layout')
@section("content")
<div class="col-12">
    <div class="box">

    <!-- /.box-header -->
    <div class="box-body"><br>
        <div class="table-responsive">
            <table id="example5" class="table table-bordered table-hover table-striped display nowrap margin-top-10 w-p100">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Parentesco</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>

            <tr>
                <td>Nome do Dependente</td>
                <td>email@email.com.br</td>
                <td>99/99/9999</td>
                <td>999.999.999-99</td>
                <td>Cônjuge</td>
                <td><a href="#"><i class='fa fa-pencil'></a></td>
                <td><a href="#"><i class='fa fa-trash'></a></td>
            </tr>

            </tbody>
        </table>
        </div>
    </div>


</div>
    <!-- /.box-body -->
    </div>
    </div>

    <!-- /.box-body -->
</div>
@endsection
@section("scriptjs")
    <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
@endsection
