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
                <th scope="col">ID</th>
                <th scope="col">Mês</th>
                <th scope="col">Data de Vencimento</th>
                <th scope="col">Data de Pagamento</th>
                <th scope="col">Valor</th>
                <th scope="col">Status</th>
                <th scope="col">Segunda Via</th>
                <th scope="col">Enviar Comprovante</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#123</td>
                <td>Junho</td>
                <td><span class="text-muted"><i class="fa fa-clock-o"></i> 99/99/9999</span> </td>
                <td><span class="text-muted"><i class="fa fa-clock-o"></i> 99/99/9999</span> </td>
                <td>R$ 9,99</td>
                <td><span class="badge badge-pill badge-success">Aprovado</span></td>
                <td><a href="#"><i class="fa fa-barcode"></i> Imprimir</a></td>
                <td><a href="#"><i class="fa fa-file-image-o"></i> Enviar</a></td>
            </tr>
        </tbody>
    </table>
    </div>
</div>


</div>
<!-- /.box-body -->
</div>
@endsection
@section("scriptjs")
<link rel="stylesheet" href="{{ asset('flexdatalist/jquery.flexdatalist.css') }}">
<script src="{{ asset('flexdatalist/jquery.flexdatalist.js') }}"></script>
<script>
$(function(){
    $('.flexdatalist').flexdatalist({
        minLength: 1
    });

})
</script>
@endsection
