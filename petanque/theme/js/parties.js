$(document).ready(function() {

// Insertion de nouveaux enregistrements
    $('#add_partie').on('click', function() {
        var date_partie = $('#date_partie').val();
        if (date_partie !== ''){
            $.ajax({
                url: './ajax/AjaxParties.php',
                type: 'POST',
                data: {
                    action: 'insert_partie',
                    date_partie: date_partie
                },
                success: function(r) {
                    $('#partie_ajoutee').removeClass('hidden').addClass('floatting');
                    $('#add_partie').attr('disabled', 'disabled');
                    setTimeout(location.reload.bind(location), 3000);
                },
                error: function(r) {}
            });
        }else{
            alert('no ajax');
        }
    });

    $("#delete_partie").on('click', "input.btn-sup-joueur", function() {
        var id = $(this).attr('id');
        $.ajax({
            url: './ajax/AjaxJoueurs.php',
            type: 'POST',
            data: {
                action: 'sup',
                id: id
            },
            success: function(r) {
                if (r.erreur){
                    alert(r.erreur);
                }else{
                    location.reload(true);
                }
            }
        });
    });
});


