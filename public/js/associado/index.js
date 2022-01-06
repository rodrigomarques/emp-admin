const verDetalhes = (event) => {
    let id = event.getAttribute("data-id")

    if (url == undefined) {
        alert("Não pode ser carregado os detalhes")
        return
    }

    url = url.replace(":pidassociado", id)
    $(".modal-component").modal("show")

    $("#modal-title-text").html("ASSOCIADO")

    fetch(url)
        .then((result) => result.text())
        .then((result) => {
            $(".modal-body-content").html(result);
        })
        .catch((erro) => {
            console.log(erro);
            alert("Associado não pode ser carregado");
        });
};


const editarAssociado = (event) => {
    let id = event.getAttribute("data-id");

    if (urlEditar == undefined) {
        alert("Não pode editar o associado");
        return;
    }

    urlEditar = urlEditar.replace(":pidassociado", id);
    location.href=urlEditar
};

const editarDependente = (event) => {
    let id = event.getAttribute("data-id");

    if (urlEditar == undefined) {
        alert("Não pode editar o dependente");
        return;
    }

    urlEditar = urlEditar.replace(":piddependente", id);
    location.href = urlEditar;
};

const deletarAssociado = (event) => {
    let id = event.getAttribute("data-id");

    if (urlExcluir == undefined) {
        alert("Não pode excluir o associado");
        return;
    }

    urlExcluir = urlExcluir.replace(":pidassociado", id);
    fetch(urlExcluir)
        .then((result) => result.json())
        .then((result) => {
            location.reload();
        })
        .catch((erro) => {
            console.log(erro);
            alert("Associado não pode ser excluído");
        });
};
