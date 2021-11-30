@extends('layout')
@section("content")
<?php $regCliente["estado"] = "RJ"; ?>
<div class="content-top-agile pb-0 titulo">
    <h2>Preencha seu endereço</h2>
</div>
<div class="p-40 pt-10">
    <form action="{{ route('associado.passo3') }}" method="post">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="Cep">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone" class="form-control pl-15 bg-transparent phone" id="phone" placeholder="Endereço">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="Número">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="Complemento">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone" class="form-control pl-15 bg-transparent" placeholder="Bairro">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="Cidade">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                    <select class="custom-select form-control" id="" name="estado">
                        <option value="" <?php if($regCliente['estado']=='AC'){ echo 'selected'; } ?>>Selecione o estado</option>
                        <option value="AC" <?php if($regCliente['estado']=='AC'){ echo 'selected'; } ?>>Acre</option>
                        <option value="AL" <?php if($regCliente['estado']=='AL'){ echo 'selected'; } ?>>Alagoas</option>
                        <option value="AP" <?php if($regCliente['estado']=='AP'){ echo 'selected'; } ?>>Amapá</option>
                        <option value="AM" <?php if($regCliente['estado']=='AM'){ echo 'selected'; } ?>>Amazonas</option>
                        <option value="BA" <?php if($regCliente['estado']=='BA'){ echo 'selected'; } ?>>Bahia</option>
                        <option value="CE" <?php if($regCliente['estado']=='CE'){ echo 'selected'; } ?>>Ceará</option>
                        <option value="DF" <?php if($regCliente['estado']=='DF'){ echo 'selected'; } ?>>Distrito Federal</option>
                        <option value="ES" <?php if($regCliente['estado']=='ES'){ echo 'selected'; } ?>>Espírito Santo</option>
                        <option value="GO" <?php if($regCliente['estado']=='GO'){ echo 'selected'; } ?>>Goiás</option>
                        <option value="MA" <?php if($regCliente['estado']=='MA'){ echo 'selected'; } ?>>Maranhão</option>
                        <option value="MT" <?php if($regCliente['estado']=='MT'){ echo 'selected'; } ?>>Mato Grosso</option>
                        <option value="MS" <?php if($regCliente['estado']=='MS'){ echo 'selected'; } ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php if($regCliente['estado']=='MG'){ echo 'selected'; } ?>>Minas Gerais</option>
                        <option value="PA" <?php if($regCliente['estado']=='PA'){ echo 'selected'; } ?>>Pará</option>
                        <option value="PB" <?php if($regCliente['estado']=='PB'){ echo 'selected'; } ?>>Paraíba</option>
                        <option value="PR" <?php if($regCliente['estado']=='PR'){ echo 'selected'; } ?>>Paraná</option>
                        <option value="PE" <?php if($regCliente['estado']=='PE'){ echo 'selected'; } ?>>Pernambuco</option>
                        <option value="PI" <?php if($regCliente['estado']=='PI'){ echo 'selected'; } ?>>Piauí</option>
                        <option value="RJ" <?php if($regCliente['estado']=='RJ'){ echo 'selected'; } ?>>Rio de Janeiro</option>
                        <option value="RN" <?php if($regCliente['estado']=='RN'){ echo 'selected'; } ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php if($regCliente['estado']=='RS'){ echo 'selected'; } ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php if($regCliente['estado']=='RO'){ echo 'selected'; } ?>>Rondônia</option>
                        <option value="RR" <?php if($regCliente['estado']=='RR'){ echo 'selected'; } ?>>Roraima</option>
                        <option value="SC" <?php if($regCliente['estado']=='SC'){ echo 'selected'; } ?>>Santa Catarina</option>
                        <option value="SP" <?php if($regCliente['estado']=='SP'){ echo 'selected'; } ?>>São Paulo</option>
                        <option value="SE" <?php if($regCliente['estado']=='SE'){ echo 'selected'; } ?>>Sergipe</option>
                        <option value="TO" <?php if($regCliente['estado']=='TO'){ echo 'selected'; } ?>>Tocantins</option>
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
