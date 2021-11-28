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
                        <label for="">Nome do Cupom</label>
                        <input type="text" name="titulo" class="form-control" value="" id="" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Código do Cupom</label>
                        <input type="text" name="codigo" class="form-control" value="" id="" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Valor do Desconto</label>
                        <br>
                            <input type="text" name="valor" class="form-control" value="" id="" required style="width:20%;display:inline-block">
                            <select name="tipo" class="custom-select form-control" style="width:20%;display:inline-block">
                                <option value="PECENT">%</option>
                                <option value="VALOR">R$</option>
                            </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Data Início</label>
                        <input type="date" name="dt_inicio" class="form-control" value="" id="" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Data de Término</label>
                        <input type="date" name="dt_termino" class="form-control" value="" id="" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Válido para alguma categoria?</label>
                        <input type='text'
                            placeholder='Categoria'
                            class='flexdatalist'
                            data-min-length='1'
                            multiple=''
                            data-selection-required='1'
                            list='categorias'
                            name='categorias'>

                        <datalist id="categorias">
                            @foreach($subcategoria as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->subcategoria }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            <div class="row">
                <input type="submit" value="Salvar" class="btn btn-success">
            </div>
        </section>
    </form>
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
