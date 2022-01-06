@extends('layout')
@section("content")
<div class="content-top-agile pb-0 titulo">
    <h2>Deseja cadastrar dependente sem custo extra?</h2>
</div>
<div class="p-40 pt-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="dependente" name="dependente">
                            <option value="">Selecione</option>
                            <option value="Sim">Sim</option>
                            <option value="Não" selected>Não</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div id="cadastroDependente" style="display:none;">
        <form action="{{ route('associado.passo3-save', ['idassociado' => $idassociado]) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="nome" class="form-control pl-15 bg-transparent" placeholder="Nome" value="{{ old('nome', '') }}" >
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="E-mail" value="{{ old('email', '') }}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="date" name="dt_nascimento" class="form-control pl-15 bg-transparent" placeholder="Data de Nascimento" value="{{ old('dt_nascimento', '') }}" >
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="cpf" class="form-control pl-15 bg-transparent" placeholder="CPF" value="{{ old('cpf', '') }}" >
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select class="custom-select form-control" id="" name="sexo">
                                <option value="">Sexo</option>
                                <option @if(old('sexo', '') == "M") selected @endif value="M">Masculino</option>
                                <option @if(old('sexo', '') == "F") selected @endif value="F">Feminino</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select class="custom-select form-control" id="" name="parentesco">
                                <option>Grau de Parentesco</option>
                                <option value="CÔNJUGE" @if(old('parentesco', '') == "CÔNJUGE") selected @endif>Cônjuge</option>
                                <option value="FILHO" @if(old('parentesco', '') == "FILHO") selected @endif>Filho(a)</option>
                                <option value="PAI/MÃE" @if(old('parentesco', '') == "PAI/MÃE") selected @endif>Pai/Mãe</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <label>Selecione seus documentos (RG, CPF ou CNH)</label>
                            <input type="file" name="arquivo" placeholder="Selecione o Arquivo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('associado.passo2', ['idassociado' => $idassociado]) }}" class="btn mt-10" style="background: #16264761; color: #FFF;">Voltar</a>
                    <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Avançar</button>
                </div>
            </div>
            </form>
        </div>
        <div id="concluir">
            <form action="{{ route('associado.passo4', ['idassociado' => $idassociado]) }}" method="post">
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('associado.passo2', ['idassociado' => $idassociado]) }}" class="btn mt-10" style="background: #16264761; color: #FFF;">Voltar</a>
                    <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Concluir Cadastro</button>
                </div>
            </div>
            </form>
        </div>

</div>
@endsection
@section("scriptjs")
<script>
    $(document).ready(function(){
        $("#dependente").change(function() {
            var dependente = $(this).val();

            if(dependente=='Sim'){
            $('#cadastroDependente').show();
            $('#concluir').hide();
            }else{
            $('#cadastroDependente').hide();
            $('#concluir').show();
            }

        });
    });
</script>
@endsection
