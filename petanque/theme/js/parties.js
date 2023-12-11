$(document).ready(function() {

// Ajout d'une partie
    // $('#add-party').on('click', function() { // debug
    $(document).ready(function() {
        let init_party = $('#party-manager').data('party_ready'),
            party_date = $('#party-date').val();
        if (init_party == '') {
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
    // $("#remove-all-rounds").on('click', function() {
    //     $.ajax({
    //         url: './ajax/AjaxRounds.php',
    //         type: 'POST',
    //         data: {
    //             action: 'remove_all_rounds'
    //         },
    //         success: function(r) {
    //             location.reload(true);
    //         },
    //         error : function(r) {
    //             alert(r.error)
    //         }
    //     });
    // });

    // Debug Ajout des équipes d'une manche
    // $('[id*="add-fights-]"').each(function() {
    //     $(this).on('click', function() {
    //         let party_id = $(this).data('party_id'),
    //             round_id = $(this).data('round_id');
    //         $.ajax({
    //             url: './ajax/AjaxTeams.php',
    //             type: 'POST',
    //             data: {
    //                 action: 'insert_fights',
    //                 party_id: party_id,
    //                 round_id: round_id
    //             },
    //             success: function(r) {
    //                 location.reload(true);
    //             },
    //             error: function(r) {}
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('[id*="teams-list-"]').each(function() {
            let round_ready = $(this).data('round_ready'),
                party_id = $(this).data('party_id'),
                round_id = $(this).data('round_id');
            if(round_ready == '') {
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
            }
        });
    });

    // Ajout des rencontres d'une manche
    // Debug
    // $('[id*="add-fights-"]').each(function() {
    //     $(this).on('click', function() {
    //         let party_id = $(this).data('party_id'),
    //             round_id = $(this).data('round_id');
    //         $.ajax({
    //             url: './ajax/AjaxFights.php',
    //             type: 'POST',
    //             data: {
    //                 action: 'insert_fights',
    //                 party_id: party_id,
    //                 round_id: round_id
    //             },
    //             success: function(r) {
    //                 location.reload(true);
    //             },
    //             error: function(r) {}
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('[id*="fights-list-"]').each(function() {
            let teams_ready = $(this).data('teams_ready'),
                fights_ready = $(this).data('fights_ready'),
                party_id = $(this).data('party_id'),
                round_id = $(this).data('round_id');
            if(teams_ready != '0' && fights_ready == '') {
                $.ajax({
                    url: './ajax/AjaxFights.php',
                    type: 'POST',
                    data: {
                        action: 'insert_fights',
                        party_id: party_id,
                        round_id: round_id
                    },
                    success: function(r) {
                        location.reload(true);
                    },
                    error: function(r) {}
                });
            }
        });
    });

    // Mettre à jour les scores
    $('#submit-scores').on('click', () => {
        $('[id*="fights-score-"]').each(function() {
        console.log($(this));
            let id = $(this).data('fight_id'),
                score_1 = $(this).find('input[name="score-1"]').val(),
                score_2 = $(this).find('input[name="score-2"]').val();
        console.log(score_1);
        console.log(score_2);
                
            $.ajax({
                url: './ajax/AjaxFights.php',
                type: 'POST',
                data: {
                    action: 'insert_scores',
                    id: id,
                    score_1: score_1,
                    score_2: score_2
                },
                success: function() {
                    // location.reload(true);
                }
            });
        });
    });
});


