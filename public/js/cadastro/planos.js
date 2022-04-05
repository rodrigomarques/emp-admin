
const editarPlano = (event) => {
    let id = event.getAttribute("data-id");

    if (urlEditar == undefined) {
        alert("Não pode editar o plano");
        return;
    }

    urlEditar = urlEditar.replace(":pidplano", id);
    location.href=urlEditar
};

const deletarPlano = (event) => {
    let id = event.getAttribute("data-id");

    if (urlExcluir == undefined) {
        alert("Não pode excluir o plano");
        return;
    }

    urlExcluir = urlExcluir.replace(":pidplano", id);
    location.href = urlExcluir;
};

