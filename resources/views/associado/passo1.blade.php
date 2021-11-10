@extends('layout')
@section("content")
<div class="content-top-agile pb-0 titulo">
    <h2>Quero ser associado</h2>
</div>
<div class="p-40 pt-10">
    <form action="cadastro2.php" method="post">
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
                        <input type="text" name="telefone" class="form-control pl-15 bg-transparent phone" placeholder="Telefone Residencial" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="celular" class="form-control pl-15 bg-transparent phone" placeholder="Celular" >
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
                        <input type="text" name="cpf" class="form-control pl-15 bg-transparent" placeholder="CPF" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone" class="form-control pl-15 bg-transparent phone" placeholder="Senha" >
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="telefone" class="form-control pl-15 bg-transparent phone" placeholder="Confirme a Senha" >
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="categoria" name="categoria">
                            <option value="">Selecione a categoria principal</option>
                            <option value="1">ALUNO ESCOLA FORMAÇÃO</option>
                            <option value="2">MILITAR DE FORÇA AUXILIAR ATIVA – CB</option>
                            <option value="2">MILITAR DE FORÇA AUXILIAR ATIVA– PM</option>
                            <option value="2">MILITAR EB ATIVA - de Carreira</option>
                            <option value="2">MILITAR EB ATIVA RM2/RM3</option>
                            <option value="2">MILITAR ESTRANGEIRO</option>
                            <option value="2">MILITAR FAB ATIVA - de Carreira</option>
                            <option value="2">MILITAR FAB ATIVA RM2/RM3</option>
                            <option value="1">MILITAR MB ATIVA - de Carreira</option>
                            <option value="1">MILITAR MB ATIVA RM2/RM3</option>
                            <option value="2">MILITAR DE FORÇA AUXILIAR RES/REF – CB</option>
                            <option value="2">MILITAR DE FORÇA AUXILIAR RES/REF– PM</option>
                            <option value="2">MILITAR EB RESERVA /REFORMADO</option>
                            <option value="2">MILITAR FAB RESERVA /REFORMADO</option>
                            <option value="1">MILITAR MB RESERVA RM1 e REFORMADO</option>
                            <option value="2">MILITAR MB RESERVA RM2</option>
                            <option value="2">CONTRATADO ACANTHUS</option>
                            <option value="2">CONVIDADO</option>
                            <option value="2">SERVIDOR CIVIL DA MB</option>
                            <option value="2">SERVIDOR DE AUTARQUIA VINCULADA A MB</option>
                            <option value="2">SERVIDOR DE ESTATAL VINCULADA A MB</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="RG" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="NIP"  id="nip" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="pagamentoNIP" name="pagamentoNIP" style="display:none">
                            <option>Forma de Pagamento</option>
                            <option>Desconto em Folha</option>
                            <option>Depósito Bancário</option>
                            <option>Boleto Bancário</option>
                            <option>Cartão de Crédito</option>
                        </select>
                        <select class="custom-select form-control" id="pagamento" name="pagamento" style="display:block">
                            <option>Forma de Pagamento</option>
                            <option>Depósito Bancário</option>
                            <option>Boleto Bancário</option>
                            <option>Cartão de Crédito</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="custom-select form-control" id="" name="plano">
                            <option>Selecione o Plano</option>
                            <option>12 meses</option>
                            <option>24 meses</option>
                            <option>36 meses</option>
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
