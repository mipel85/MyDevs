$(document).ready(function() {

// Ajout d'une partie
    $('#add-party').on('click', function() {
        var date_partie = $('#date_partie').val();
        if (date_partie !== ''){
            $.ajax({
                url: './ajax/AjaxParties.php',
                type: 'POST',
                data: {
                    action: 'insert_party',
                    date_partie: date_partie
                },
                success: function(r) {
                    $('#partie_ajoutee').removeClass('hidden').addClass('floatting');
                    $('#add-party').attr('disabled', 'disabled');
                    setTimeout(location.reload.bind(location), 3000);
                },
                error: function(r) {}
            });
        }else{
            alert('no ajax');
        }
    });

    // Supprimer une partie
    $("#table_liste_parties").on('click', "button.btn-sup-partie", function() {
        var id = $(this).attr('id');
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'delete_party',
                id: id
            },
            success: function(r) {
                location.reload(true);
            },
            error : function(r) {
                alert(r.error)
            }
        });
    });

    // Supprimer toutes les parties
    $("#delete-all-parties").on('click', function() {
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'delete_all_parties'
            },
            success: function(r) {
                location.reload(true);
            },
            error : function(r) {
                alert(r.error)
            }
        });
    });

    // Ajout d'une manche
    $('#add_manche').on('click', function() {
        let party_id = $(this).data('party_id'),
            i_order = $(this).data('i_order'),
            players_number = $(this).data('players_number');
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'insert_round',
                party_id: party_id,
                i_order: i_order,
                players_number: players_number
            },
            success: function(r) {
                $('#manche_ajoutee').removeClass('hidden').addClass('floatting');
                if (i_order > 4) $('#add-manche').attr('disabled', 'disabled');
                setTimeout(location.reload.bind(location), 1500);
            },
            error: function(r) {}
        });
    });
    
    // Supprimer une partie
    $("#table_liste_manches").on('click', "button.btn-sup-manche", function() {
        var id = $(this).attr('id');
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'delete_round',
                id: id
            },
            success: function(r) {
                location.reload(true);
            },
            error : function(r) {
                alert(r.error)
            }
        });
    });

    // Supprimer toutes les manches
    $("#delete-all-manches").on('click', function() {
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'delete_all_manches'
            },
            success: function(r) {
                location.reload(true);
            },
            error : function(r) {
                alert(r.error)
            }
        });
    });
});


