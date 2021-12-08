<div class="row">
    <div class="col-xl-6 col-12">
        Nome: {{ $associado->nome }}<br>
        E-mail: {{ $associado->email }}<br>
        Telefone: {{ $associado->telefone_res }}<br>
        Celular: {{ $associado->telefone_cel }}<br>
        RG: {{ $associado->rg }}<br>
        CPF: {{ $associado->cpf }}<br>
        Sexo: {{ $associado->sexo }}<br>
        Endereço: {{ $associado->endereco }} {{ $associado->numero }} {{ $associado->complemento }} - {{ $associado->bairro }} - {{ $associado->cidade }} {{ $associado->estado }}<br>
        CEP: {{ $associado->cep }}<br>
        Categoria: {{ $associado->subcategoria }}<br>
    </div>
    <div class="col-xl-6 col-12">
        Documento: <a href="{{ asset($associado->documento) }}" target="_blank">Clique para Visualizar</a>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-12">
        Forma de Pagamento: {{ $associado->forma_pagamento }}<br>
        Plano: {{ $associado->plano }} meses<br>
        Vencimento do Plano: 99/99/9999
    </div>
</div>
<hr>
<strong>DEPENDENTES</strong><br>
</p>
<div class="row">
    @foreach($deps as $dep)
    <div class="col-xl-4 col-12">
        Nome: {{ $dep->nome }}<br>
        E-mail: {{ $dep->email }}<br>
        CPF: {{ $dep->cpf }}<br>
        Data de Nascimento: {{ \App\Util\Format::fnDateView($dep->dt_nascimento) }}<br>
        Sexo: {{ $dep->sexo }}<br>
        Parentesco: {{ $dep->parentesco }}
    </div>
    @endforeach
</div>
