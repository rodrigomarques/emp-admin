@extends('admin.layout')
@section("content")
<div class="col-12">
    <div class="box">

    <div class="box-body wizard-content">
    <form action="{{ route('admin.associado.editar.save', ['idassociado' => $idassociado]) }}" enctype="multipart/form-data" method="post" class="tab-wizard wizard-circle">
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $associado->nome }}" id="" required> </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ $associado->email }}" id="" required> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">RG</label>
                        <input type="text" name="rg" class="form-control" value="{{ $associado->rg }}" id="" required> </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">CPF</label>
                        <input type="text" name="cpf" class="form-control" value="{{ $associado->cpf }}" id="" required> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Sexo</label>
                        <select class="custom-select form-control" id="" name="sexo">
                            <option value="M" @if($associado->sexo == "M") selected @endif >Masculino</option>
                            <option value="F"  @if($associado->sexo == "F") selected @endif>Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select class="form-control" name="subcategoria_id">
                        <option value="">Selecione a categoria principal</option>
                        @if(count($listSubCategoria) > 0)
                            @foreach($listSubCategoria as $sub)
                                <option @if($associado->subcategoria_id == $sub->id) selected @endif value="{{ $sub->id }}">{{ $sub->subcategoria }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Telefone</label>
                        <input type="text" name="telefone_res" class="form-control" value="{{ $associado->telefone_res }}" id="" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Celular</label>
                        <input type="text" name="telefone_cel" class="form-control" value="{{ $associado->telefone_cel }}" id="" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Cep</label>
                        <input type="text" name="cep" class="form-control" value="{{ $associado->cep }}" id=""> </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Endereço</label>
                        <input type="text" name="endereco" value="{{ $associado->endereco }}" class="form-control" id=""> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Número</label>
                        <input type="text" name="numero" class="form-control" value="{{ $associado->numero }}" id=""> </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Complemento</label>
                        <input type="text" name="complemento" class="form-control" value="{{ $associado->complemento }}" id=""> </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="">Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="{{ $associado->bairro }}" id=""> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date1">Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="{{ $associado->cidade }}" id=""> </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location3">Estado</label>
                        <select class="custom-select form-control" id="" name="estado">
                            <option @if($associado->estado == "AC") selected @endif value="AC">Acre</option>
                            <option @if($associado->estado == "AL") selected @endif value="AL">Alagoas</option>
                            <option @if($associado->estado == "AP") selected @endif value="AP">Amapá</option>
                            <option @if($associado->estado == "AM") selected @endif value="AM">Amazonas</option>
                            <option @if($associado->estado == "BA") selected @endif value="BA">Bahia</option>
                            <option @if($associado->estado == "CE") selected @endif value="CE">Ceará</option>
                            <option @if($associado->estado == "DF") selected @endif value="DF">Distrito Federal</option>
                            <option @if($associado->estado == "ES") selected @endif value="ES">Espírito Santo</option>
                            <option @if($associado->estado == "GO") selected @endif value="GO">Goiás</option>
                            <option @if($associado->estado == "MA") selected @endif value="MA">Maranhão</option>
                            <option @if($associado->estado == "MT") selected @endif value="MT">Mato Grosso</option>
                            <option @if($associado->estado == "MS") selected @endif value="MS">Mato Grosso do Sul</option>
                            <option @if($associado->estado == "MG") selected @endif value="MG">Minas Gerais</option>
                            <option @if($associado->estado == "PA") selected @endif value="PA">Pará</option>
                            <option @if($associado->estado == "PB") selected @endif value="PB">Paraíba</option>
                            <option @if($associado->estado == "PR") selected @endif value="PR">Paraná</option>
                            <option @if($associado->estado == "PE") selected @endif value="PE">Pernambuco</option>
                            <option @if($associado->estado == "PI") selected @endif value="PI">Piauí</option>
                            <option @if($associado->estado == "RJ") selected @endif value="RJ">Rio de Janeiro</option>
                            <option @if($associado->estado == "RN") selected @endif value="RN">Rio Grande do Norte</option>
                            <option @if($associado->estado == "RS") selected @endif value="RS">Rio Grande do Sul</option>
                            <option @if($associado->estado == "RO") selected @endif value="RO">Rondônia</option>
                            <option @if($associado->estado == "RR") selected @endif value="RR">Roraima</option>
                            <option @if($associado->estado == "SC") selected @endif value="SC">Santa Catarina</option>
                            <option @if($associado->estado == "SP") selected @endif value="SP">São Paulo</option>
                            <option @if($associado->estado == "SE") selected @endif value="SE">Sergipe</option>
                            <option @if($associado->estado == "TO") selected @endif value="TO">Tocantins</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($associado->documento != "")
                    <div class="col-md-4">
                        <div class="form-group">
                            <a href="{{ asset( $associado->documento) }}" target="_blank">Download Arquivo</a>
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
                            <option value="ATIVO"  @if($associado->status == "ATIVO") selected @endif>ATIVO</option>
                            <option value="INATIVO"  @if($associado->status == "INATIVO") selected @endif>INATIVO</option>
                            <option value="CANCELADO"  @if($associado->status == "CANCELADO") selected @endif>CANCELADO</option>
                            <option value="EM_PROCESSO"  @if($associado->status == "EM_PROCESSO") selected @endif>EM PROCESSO</option>
                            <option value="AGUARDANDO_LIBERACAO"  @if($associado->status == "AGUARDANDO_LIBERACAO") selected @endif>AGUARDANDO LIBERACAO</option>
                            <option value="AGUARDANDO_PAGAMENTO"  @if($associado->status == "AGUARDANDO_PAGAMENTO") selected @endif>AGUARDANDO PAGAMENTO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nova Senha</label>
                        <input type="password" name="senha" class="form-control" value="" id="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Repita a Senha</label>
                        <input type="password" name="csenha" class="form-control" value="" id="">
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
