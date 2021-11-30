@extends('layout')
@section("content")
<div class="content-top-agile pb-0 titulo">
    <h2>Quero ser associado</h2>
</div>
<div class="p-40 pt-10">
    <form action="{{ route('associado.passo1-save') }}" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" name="nome" class="form-control pl-15 bg-transparent" placeholder="Nome Completo" >
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-transparent"><i class="ti-email"></i></span>
                        </div>
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="E-mail" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone_res" class="form-control pl-15 bg-transparent phone" placeholder="Telefone Residencial" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone_cel" class="form-control pl-15 bg-transparent phone" placeholder="Celular" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="sexo" name="sexo">
                            <option value="">Sexo</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="cpf" class="form-control pl-15 bg-transparent" placeholder="CPF" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" name="senha" class="form-control pl-15 bg-transparent phone" placeholder="Senha" >
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="password" name="csenha" class="form-control pl-15 bg-transparent phone" placeholder="Confirme a Senha" >
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
                                    <option value="{{ $sub->id }}">{{ $sub->subcategoria }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="rg" class="form-control pl-15 bg-transparent" placeholder="RG" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="nip" class="form-control pl-15 bg-transparent" placeholder="NIP"  id="nip" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="pagamentoNIP" name="pagamentoNIP" style="display:none">
                            <option value="">Forma de Pagamento</option>
                            <option value="FOLHA">Desconto em Folha</option>
                            <option value="DEPOSITO">Depósito Bancário</option>
                            <option value="BOLETO">Boleto Bancário</option>
                            <option value="CREDITO">Cartão de Crédito</option>
                        </select>
                        <select class="custom-select form-control" id="pagamento" name="pagamento" style="display:block">
                            <option value="">Forma de Pagamento</option>
                            <option value="DEPOSITO">Depósito Bancário</option>
                            <option value="BOLETO">Boleto Bancário</option>
                            <option value="CREDITO">Cartão de Crédito</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="" name="plano">
                            <option>Selecione o Plano</option>
                            <option value="12">12 meses</option>
                            <option value="24">24 meses</option>
                            <option value="36">36 meses</option>
                        </select>
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
