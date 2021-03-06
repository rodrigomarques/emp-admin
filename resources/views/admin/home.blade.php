@extends('admin.layout')
@section("content")

<div class="col-xl-3 col-md-6 col-12">
    <div class="box">
        <ul class="box-controls pull-right">
            <li class="dropdown">
            <a data-toggle="dropdown" href="#" class="px-10 pt-5"></a>
            <div class="dropdown-menu dropdown-menu-right">
            </div>
            </li>
        </ul>
        <div class="box-body pt-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="icon bg-danger-light rounded-circle">
                    <i class="text-danger mr-0 font-size-20 fa fa-users"></i>
                </div>
                <div>
                    <h3 class="text-dark mb-0 font-weight-500">{{ $total }}</h3>
                    <p class="text-mute mb-0">Associados</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 col-12">
    <div class="box">
        <ul class="box-controls pull-right">
            <li class="dropdown">
            <a data-toggle="dropdown" href="#" class="px-10 pt-5"></a>
            <div class="dropdown-menu dropdown-menu-right">
            </div>
            </li>
        </ul>
        <div class="box-body pt-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="icon bg-danger-light rounded-circle">
                    <i class="text-danger mr-0 font-size-20 fa fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="text-dark mb-0 font-weight-500">{{ $totalDependente }}</h3>
                    <p class="text-mute mb-0">Dependentes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 col-12">
    <div class="box">
        <ul class="box-controls pull-right">
            <li class="dropdown">
            <a data-toggle="dropdown" href="#" class="px-10 pt-5"></a>
            <div class="dropdown-menu dropdown-menu-right">
            </div>
            </li>
        </ul>
        <div class="box-body pt-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="icon bg-danger-light rounded-circle">
                    <i class="text-danger mr-0 font-size-20 fa fa-thumbs-up"></i>
                </div>
                <div>
                    <h3 class="text-dark mb-0 font-weight-500">{{ count($totalAtivos) }}</h3>
                    <p class="text-mute mb-0">Ativos</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 col-12">
    <div class="box">
        <ul class="box-controls pull-right">
            <li class="dropdown">
            <a data-toggle="dropdown" href="#" class="px-10 pt-5"></a>
            <div class="dropdown-menu dropdown-menu-right">
            </div>
            </li>
        </ul>
        <div class="box-body pt-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="icon bg-danger-light rounded-circle">
                    <i class="text-danger mr-0 font-size-20 fa fa-times"></i>
                </div>
                <div>
                    <h3 class="text-dark mb-0 font-weight-500">{{ count($totalInativos) }}</h3>
                    <p class="text-mute mb-0">Inativos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gr??fico Financeiro -->
<div class="col-xl-12 col-12">
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">Cadastros de Associados Ativos</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 col-12">

                    <!-- Gr??fico -->
                    <!-- Este gr??fico vai mostrar o total de associados ativos dentro do m??s, sempre ser?? cumulativo. Exemplo, junho tinham 100 ativos e julho entraram + 10, ent??o julho ir?? mostrar 110. -->
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            fetch('{{ route("admin.ajax.associados.ativos") }}')
                            .then( result => result.json())
                            .then((result) => {
                                let dados = [
                                    ["M??s", "Associados", { role: "style" } ],
                                ]
                                if(result.data.length > 0){
                                    result.data.forEach(value => {
                                        dados.push(value)
                                    })
                                }
                                let data = google.visualization.arrayToDataTable(dados);
                                var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                                            { calc: "stringify",
                                                sourceColumn: 1,
                                                type: "string",
                                                role: "annotation" },
                                            2]);
                                var options = {
                                    title: "",
                                    height: 300,
                                    bar: {groupWidth: "95%"},
                                    legend: { position: "none" },
                                };
                                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                                chart.draw(view, options);
                            })
                            .catch(erro => { console.log(erro); alert("Associados ativos n??o podem ser carregado") })

                        }
                        </script>
                    <div id="columnchart_values" style="width: 100%; height: 300px;"></div>
                    <!-- Gr??fico -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gr??fico Financeiro -->

<!-- Gr??fico Cadastros -->
<div class="col-xl-12 col-12">
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">Cadastros de Associados - Entrada x Sa??da</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 col-12">

                    <!-- Gr??fico -->
                    <!-- Este gr??fico vai mostrar o total de associados que entraram e que sa??ram dentro do m??s -->
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                fetch('{{ route("admin.ajax.associados.ativos.inativos") }}')
                                .then( result => result.json())
                                .then((result) => {
                                    let dados = [
                                        ['', 'Ativos', 'Inativos']
                                    ]
                                    if(result.data.length > 0){
                                        result.data.forEach(value => {
                                            dados.push(value)
                                        })
                                    }
                                    let data = google.visualization.arrayToDataTable(dados);
                                    var options = {
                                        chart: {
                                        title: '',
                                        subtitle: '',
                                        }
                                    };

                                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                    chart.draw(data, google.charts.Bar.convertOptions(options));
                                })
                                .catch(erro => { console.log(erro); alert("Associados ativos n??o podem ser carregado") })
                            }
                        </script>
                    <div id="columnchart_material" style="width: 100%; height: 300px;"></div>
                    <!-- Gr??fico -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gr??fico Cadastros -->

<!-- Gr??fico de cursos -->
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        fetch('{{ route("admin.ajax.planos") }}')
        .then( result => result.json())
        .then((result) => {
            let dados = [
                [ 'Plano', 'Prazo' ]
            ]
            if(result.data.length > 0){
                result.data.forEach(value => {
                    dados.push(value)
                })
            }
            let data = google.visualization.arrayToDataTable(dados);
            let options = {
                title: '',
                pieHole: 0.4,
                chartArea:{left:10,top:10,width:"100%",height:"100%"},
            };

            let chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        })
        .catch(erro => { console.log(erro); alert("Plano n??o pode ser carregado") })
    }
</script>
<div class="col-xl-6 col-12">
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">Planos</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div id="donutchart" style="width: 450px; height: 285px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gr??fico de cursos -->

<!-- Gr??fico de cursos -->
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        fetch('{{ route("admin.ajax.categorias") }}')
        .then( result => result.json())
        .then((result) => {
            let dados = [
                ['Categoria', 'Associados']
            ]
            if(result.data.length > 0){
                result.data.forEach(value => {
                    dados.push(value)
                })
            }
            let data = google.visualization.arrayToDataTable(dados);
            let options = {
                title: '',
                pieHole: 0.4,
                chartArea:{left:10,top:10,width:"100%",height:"100%"},
            };

            let chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
            chart.draw(data, options);
        })
        .catch(erro => { console.log(erro); alert("Plano n??o pode ser carregado") })
    }
</script>
<div class="col-xl-6 col-12">
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">Categoria</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div id="donutchart2" style="width: 450px; height: 285px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gr??fico de cursos -->

@endsection
@section("scriptjs")

@endsection
