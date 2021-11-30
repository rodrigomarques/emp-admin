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
        <form action="{{ route('associado.passo4') }}" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="nome" class="form-control pl-15 bg-transparent phone" placeholder="Nome">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="E-mail">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="data" class="form-control pl-15 bg-transparent" placeholder="Data de Nascimento">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="cpf" class="form-control pl-15 bg-transparent" placeholder="CPF">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select class="custom-select form-control" id="" name="plano">
                                <option>Sexo</option>
                                <option>Masculino</option>
                                <option>Feminino</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select class="custom-select form-control" id="" name="plano">
                                <option>Grau de Parentesco</option>
                                <option>Cônjuge</option>
                                <option>Filho(a)</option>
                                <option>Pai/Mãe</option>
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
                    <a href="{{ route('associado.passo2') }}" class="btn mt-10" style="background: #16264761; color: #FFF;">Voltar</a>
                    <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Avançar</button>
                </div>
            </div>
            </form>
        </div>
        <div id="concluir">
            <form action="{{ route('associado.passo4') }}" method="post">
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('associado.passo2') }}" class="btn mt-10" style="background: #16264761; color: #FFF;">Voltar</a>
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
