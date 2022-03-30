
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

const deletarDependente = (event) => {
    let id = event.getAttribute("data-id");

    if (urlExcluir == undefined) {
        alert("Não pode excluir o dependente");
        return;
    }

    urlExcluir = urlExcluir.replace(":piddependente", id);
    location.href = urlExcluir;
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
