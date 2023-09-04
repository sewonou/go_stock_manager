$('#add-outInventoryLine').click(function(){
    // Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    // Je récupère le prototype des entrées
    const tmpl = $('#out_inventory_outInventoryLines').data('prototype').replace(/__name__/g, index);
    /*const tmpl = $('#sale_saleLines').data('prototype').replace(/__name__/g, index);*/
    const idMatches = tmpl.match(/id="([^"]+)"/);
    const tmplId = idMatches ? idMatches[1] : null;
    const outInventoryLines = document.getElementsByClassName("out-inventory-line");

    // J'injecte ce code au sein de la div
    //console.log(tmpl)  ;
    $('#outInventoryLine').append(tmpl);
    Array.from(outInventoryLines).forEach(outInventoryLine => {

    });
    $('#widgets-counter').val(index + 1);

    // Je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#out_inventory_outInventoryLines table tr.out-inventory-line').length;

    $('#widgets-counter').val(count);
}
