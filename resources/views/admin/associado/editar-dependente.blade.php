@extends('admin.layout')
@section("content")
<div class="col-12">
    <div class="box">

    <div class="box-body wizard-content">
    <form action="{{ route('admin.associado.dependentes.editar.save', ['iddependente' => $iddependente]) }}" enctype="multipart/form-data" method="post" class="tab-wizard wizard-circle">
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $dependente->nome }}" id="" required> </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ $dependente->email }}" id="" required> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">CPF</label>
                        <input type="text" name="cpf" class="form-control" value="{{ $dependente->cpf }}" id="" required> </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Grau de Parentesco</label>
                        <div class="input-group mb-3">
                            <select class="custom-select form-control" id="" name="parentesco">
                                <option>Grau de Parentesco</option>
                                <option value="CÔNJUGE"  @if($dependente->parentesco == "CÔNJUGE") selected @endif>Cônjuge</option>
                                <option value="FILHO"  @if($dependente->parentesco == "FILHO") selected @endif>Filho(a)</option>
                                <option value="PAI/MÃE" @if($dependente->parentesco == "PAI/MÃE") selected @endif>Pai/Mãe</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Data Nascimento</label>
                        <div class="input-group mb-3">
                            <input type="date" name="dt_nascimento" class="form-control pl-15 bg-transparent" placeholder="Data de Nascimento" value="{{ $dependente->dt_nascimento }}" >
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Sexo</label>
                        <select class="custom-select form-control" id="" name="sexo">
                            <option value="M" @if($dependente->sexo == "M") selected @endif >Masculino</option>
                            <option value="F"  @if($dependente->sexo == "F") selected @endif>Feminino</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                @if($dependente->documento != "")
                    <div class="col-md-4">
                        <div class="form-group">
                            <a href="{{ asset( $dependente->documento) }}" target="_blank">Download Arquivo</a>
                        </div>
                    </div>
                @endif
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Selecione os documentos (RG, CPF ou CNH)</label>
                        <input type="file" name="arquivo" placeholder="Selecione o Arquivo">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="custom-select form-control" >
                            <option value="ATIVO"  @if($dependente->status == "ATIVO") selected @endif>ATIVO</option>
                            <option value="INATIVO"  @if($dependente->status == "INATIVO") selected @endif>INATIVO</option>
                            <option value="CANCELADO"  @if($dependente->status == "CANCELADO") selected @endif>CANCELADO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" value="Salvar" class="btn btn-primary">
                </div>
            </div>
        </section>
    </form>
</div>

    <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
@endsection
@section("scriptjs")

@endsection
