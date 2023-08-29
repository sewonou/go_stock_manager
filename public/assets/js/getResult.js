const codeBarFields = document.getElementByclass('save_line_codeBar');
Array.from(codeBarInputs).forEach(input => {
    console.log(input);
});
/*

// Sélectionnez le champ codeBar par son ID
const  // Remplacez par l'ID réel
const productNameField = document.getElementById('save_line_product');
const productPriceField = document.getElementById('save_line_salePrice');
const productStockQteField = document.getElementById('save_line_stockQte');

// Sélectionnez le bouton Valider par son ID
const saveButton = document.getElementById('save_line_submit');

// Écouteur d'événement lors du changement dans le champ codeBar
codeBarField.addEventListener('blur', function() {
    const codeBarValue = codeBarField.value;

    // Activez ou désactivez le bouton Valider en fonction de la présence de valeur dans le champ codeBar
    if (codeBarValue.trim() !== '') {
        saveButton.removeAttribute('disabled');
    } else {
        saveButton.setAttribute('disabled', 'disabled');
    }
    
    console.log(codeBarValue);

    // Envoyez une requête AJAX pour récupérer d'autres données si nécessaire
    fetch('/sales/get_product', { // Remplacez par le chemin de votre route Symfony
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'code_bar_value=' + encodeURIComponent(codeBarValue),
    })
        .then(response => response.json())
        .then(data => {
            // Utilisez les données récupérées par Symfony via AJAX
            console.log('Données récupérées :', data);
            console.log('Nom du produit :', data.data.name);
            console.log('Prix du produit :', data.data.name);
            if(data.data.name && data.data.price){
                productNameField.value = data.data.name;
                productPriceField.value = data.data.price;
            }else{
                productNameField.value = '';
                productPriceField.value = '';
            }

        })
        .catch(error => {
            alert('Une erreur est survenue :', error.error);
        });
});
*/
