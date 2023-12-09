$(document).ready(function() {

// Ajout d'une partie
    $('#add-party').on('click', function() {
        var party_date = $('#party-date').val();
        if (party_date !== ''){
            $.ajax({
                url: './ajax/AjaxParties.php',
                type: 'POST',
                data: {
                    action: 'insert_party',
                    party_date: party_date
                },
                success: function(r) {
                    $('#add-party').attr('disabled', 'disabled');
                    location.reload(true);
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        } else {
            alert('no ajax');
        }
    });

    // Supprimer une partie
    $(".remove-party").each(function() {
        $(this).on('click', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: './ajax/AjaxParties.php',
                type: 'POST',
                data: {
                    action: 'remove_party',
                    party_id: id
                },
                success: function(r) {
                    location.reload(true);
                },
                error : function(r) {
                    alert(r.error);
                }
            });
        });
    });

    // Supprimer toutes les parties
    $("#remove-all-parties").on('click', function() {
        $.ajax({
            url: './ajax/AjaxParties.php',
            type: 'POST',
            data: {
                action: 'remove_all_parties'
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
    $('#add-round').on('click', function() {
        let party_id = $(this).data('party_id'),
            i_order = $(this).data('i_order'),
            players_number = $(this).data('players_number');
        $.ajax({
            url: './ajax/AjaxRounds.php',
            type: 'POST',
            data: {
                action: 'insert_round',
                party_id: party_id,
                i_order: i_order,
                players_number: players_number
            },
            success: function(r) {
                if (i_order > 4) $('#add-round').attr('disabled', 'disabled');
                location.reload(true);
            },
            error: function(r) {}
        });
    });
    
    // Supprimer une manche
    $(".remove-round").each(function() {
        $(this).on('click', function() {
            let party_id = $(this).data('party_id');
            let round_id = $(this).data('round_id');
            $.ajax({
                url: './ajax/AjaxRounds.php',
                type: 'POST',
                data: {
                    action: 'remove_round',
                    party_id: party_id,
                    round_id: round_id
                },
                success: function(r) {
                    location.reload(true);
                },
                error : function(r) {
                    alert(r.error)
                }
            });
        });
    })

    // Supprimer toutes les manches
    $("#remove-all-rounds").on('click', function() {
        $.ajax({
            url: './ajax/AjaxRounds.php',
            type: 'POST',
            data: {
                action: 'remove_all_rounds'
            },
            success: function(r) {
                location.reload(true);
            },
            error : function(r) {
                alert(r.error)
            }
        });
    });

    // Ajout des équipes d'une manche
    $('[id*="add-teams-"').each(function() {
        $(this).on('click', function() {
            let party_id = $(this).data('party_id'),
                round_id = $(this).data('round_id');
            $.ajax({
                url: './ajax/AjaxTeams.php',
                type: 'POST',
                data: {
                    action: 'insert_teams',
                    party_id: party_id,
                    round_id: round_id
                },
                success: function(r) {
                    location.reload(true);
                },
                error: function(r) {}
            });
        });
    })
});


