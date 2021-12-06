@extends('layout')
@section("content")
<?php $regCliente["estado"] = "RJ"; ?>
<div class="content-top-agile pb-0 titulo">
    <h2>Preencha seu endereço</h2>
</div>
<div class="p-40 pt-10">
    <form action="{{ route('associado.passo2-save', ['idassociado' => $idassociado]) }}" method="post">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="cep" class="form-control pl-15 bg-transparent" placeholder="Cep" value="{{ old('cep', '') }}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="endereco" class="form-control pl-15 bg-transparent " id="endereco" placeholder="Endereço" value="{{ old('endereco', '') }}" >
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="numero" class="form-control pl-15 bg-transparent" placeholder="Número" value="{{ old('numero', '') }}" >
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="complemento" class="form-control pl-15 bg-transparent" placeholder="Complemento" value="{{ old('complemento', '') }}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="bairro" class="form-control pl-15 bg-transparent" placeholder="Bairro" value="{{ old('bairro', '') }}" >
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="cidade" class="form-control pl-15 bg-transparent" placeholder="Cidade" value="{{ old('cidade', '') }}" >
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                    <select class="custom-select form-control" id="" name="estado">
                        <option value="" >Selecione o estado</option>
                        <option value="AC" @if(old('estado', '') == "AC") selected @endif >Acre</option>
                        <option value="AL" @if(old('estado', '') == "AL") selected @endif >Alagoas</option>
                        <option value="AP" @if(old('estado', '') == "AP") selected @endif >Amapá</option>
                        <option value="AM" @if(old('estado', '') == "AM") selected @endif >Amazonas</option>
                        <option value="BA" @if(old('estado', '') == "BA") selected @endif >Bahia</option>
                        <option value="CE" @if(old('estado', '') == "CE") selected @endif >Ceará</option>
                        <option value="DF" @if(old('estado', '') == "DF") selected @endif >Distrito Federal</option>
                        <option value="ES" @if(old('estado', '') == "ES") selected @endif >Espírito Santo</option>
                        <option value="GO" @if(old('estado', '') == "GO") selected @endif >Goiás</option>
                        <option value="MA" @if(old('estado', '') == "MA") selected @endif >Maranhão</option>
                        <option value="MT" @if(old('estado', '') == "MT") selected @endif >Mato Grosso</option>
                        <option value="MS" @if(old('estado', '') == "MS") selected @endif >Mato Grosso do Sul</option>
                        <option value="MG" @if(old('estado', '') == "MG") selected @endif >Minas Gerais</option>
                        <option value="PA" @if(old('estado', '') == "PA") selected @endif >Pará</option>
                        <option value="PB" @if(old('estado', '') == "PB") selected @endif >Paraíba</option>
                        <option value="PR" @if(old('estado', '') == "PR") selected @endif >Paraná</option>
                        <option value="PE" @if(old('estado', '') == "PE") selected @endif >Pernambuco</option>
                        <option value="PI" @if(old('estado', '') == "PI") selected @endif >Piauí</option>
                        <option value="RJ" @if(old('estado', '') == "RJ") selected @endif >Rio de Janeiro</option>
                        <option value="RN" @if(old('estado', '') == "RN") selected @endif >Rio Grande do Norte</option>
                        <option value="RS" @if(old('estado', '') == "RS") selected @endif >Rio Grande do Sul</option>
                        <option value="RO" @if(old('estado', '') == "RO") selected @endif >Rondônia</option>
                        <option value="RR" @if(old('estado', '') == "RR") selected @endif >Roraima</option>
                        <option value="SC" @if(old('estado', '') == "SC") selected @endif >Santa Catarina</option>
                        <option value="SP" @if(old('estado', '') == "SP") selected @endif >São Paulo</option>
                        <option value="SE" @if(old('estado', '') == "SE") selected @endif >Sergipe</option>
                        <option value="TO" @if(old('estado', '') == "TO") selected @endif >Tocantins</option>
                    </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('associado.passo1') }}" class="btn mt-10" style="background: #16264761; color: #FFF;">Voltar</a>
                <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Avançar</button>
            </div>
        </div>
    </form>
</div>
@endsection
