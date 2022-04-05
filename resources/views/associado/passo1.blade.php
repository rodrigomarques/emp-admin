@extends('layout')
@section("content")
<div class="content-top-agile pb-0 titulo">
    <h2>Quero ser associado</h2>
</div>
<div class="p-40 pt-10">
    <form action="{{ route('associado.passo1-save') }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" name="nome" class="form-control pl-15 bg-transparent" placeholder="Nome Completo" value="{{ old('nome', '') }}" >
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-transparent"><i class="ti-email"></i></span>
                        </div>
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="E-mail" value="{{ old('email', '') }}"  >
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-transparent"><i class="ti-email"></i></span>
                        </div>
                        <input type="text" name="confirmar_email" class="form-control pl-15 bg-transparent" placeholder="Confirmar E-mail" value=""  >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone_res" class="form-control pl-15 bg-transparent phone" placeholder="Telefone Residencial" value="{{ old('telefone_res', '') }}"  >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone_cel" class="form-control pl-15 bg-transparent phone" placeholder="Celular" value="{{ old('telefone_cel', '') }}"  >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="sexo" name="sexo">
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
                        <input type="text" name="cpf" class="form-control pl-15 bg-transparent cpf" placeholder="CPF" value="{{ old('cpf', '') }}"  >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" name="senha" class="form-control pl-15 bg-transparent " placeholder="Senha" value="" >
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" name="csenha" class="form-control pl-15 bg-transparent " placeholder="Confirme a Senha" value="" >
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="subcategoria" name="subcategoria_id">
                            <option value="">Selecione a categoria principal</option>
                            @if(count($listSubCategoria) > 0)
                                @foreach($listSubCategoria as $sub)
                                    <option @if(old('subcategoria_id', '') == $sub->id) selected @endif data-tipo="{{ $sub->tipo }}" value="{{ $sub->id }}">{{ $sub->subcategoria }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="rg" class="form-control pl-15 bg-transparent" placeholder="RG" value="{{ old('rg', '') }}"  >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="nip" class="form-control pl-15 bg-transparent nip" placeholder="NIP"  id="nip" disabled value="{{ old('nip', '') }}"  >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control pagamento" id="pagamentoNIP" name="pagamentoNIP" style="display:none">
                            <option value="">Forma de Pagamento</option>
                            <option @if(old('pagamentoNIP', '') == "FOLHA") selected @endif value="FOLHA">Desconto em Folha</option>
                            <option @if(old('pagamentoNIP', '') == "DEPOSITO") selected @endif value="DEPOSITO">Depósito Bancário</option>
                            <option @if(old('pagamentoNIP', '') == "BOLETO") selected @endif value="BOLETO">Boleto Bancário</option>
                            <option @if(old('pagamentoNIP', '') == "CREDITO") selected @endif value="CREDITO">Cartão de Crédito</option>
                            <option @if(old('pagamentoNIP', '') == "PIX") selected @endif value="PIX">PIX</option>
                        </select>
                        <select class="custom-select form-control pagamento" id="pagamento" name="pagamento" style="display:block">
                            <option value="">Forma de Pagamento</option>
                            <option @if(old('pagamento', '') == "DEPOSITO") selected @endif value="DEPOSITO">Depósito Bancário</option>
                            <option @if(old('pagamento', '') == "BOLETO") selected @endif value="BOLETO">Boleto Bancário</option>
                            <option @if(old('pagamento', '') == "CREDITO") selected @endif value="CREDITO">Cartão de Crédito</option>
                            <option @if(old('pagamento', '') == "PIX") selected @endif value="PIX">PIX</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3" id="dvplano">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="plano_id" name="plano_id">
                            <option>Selecione o Plano</option>
                            @foreach($listPlanos as $plano)
                                <option @if(old('plano_id', "") == $plano->id) selected @endif value="{{ $plano->id }}">{{ $plano->plano }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label >Associado do abrigo do marinheiro (AMN)?</label>
                    <div class="input-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="amn" id="amn_sim" value="S" @if(old('amn') == "S") checked @endif>
                            <label class="form-check-label" for="amn_sim">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="amn" id="amn_nao" value="N" @if(old('amn') == "N") checked @endif>
                            <label class="form-check-label" for="amn_nao">
                                Não
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <label>Selecione os documentos (RG, CPF ou CNH)</label>
                        <input type="file" name="arquivo" placeholder="Selecione o Arquivo">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Avançar</button>
            </div>
        </div>
    </form>
</div>
@endsection
