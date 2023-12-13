$(document).ready(function() {

// Ajout d'une partie
    // $('#add-day').on('click', function() { // debug
    $(document).ready(function() {
        let init_day = $('#day-manager').data('day_ready'),
            day_date = $('#day-date').val();
        if (init_day == '') {
            $.ajax({
                url: './ajax/AjaxDays.php',
                type: 'POST',
                data: {
                    action: 'insert_day',
                    day_date: day_date,
                    fields_number: 10,
                    fields_list: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
                },
                success: function(r) {
                    $('#add-day').attr('disabled', 'disabled');
                    location.reload(true);
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        }
    });

    // Supprimer une partie
    $(".remove-day").each(function() {
        $(this).on('click', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: './ajax/AjaxDays.php',
                type: 'POST',
                data: {
                    action: 'remove_day',
                    day_id: id
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

    // Supprimer toutes les days
    $("#remove-all-days").on('click', function() {
        $.ajax({
            url: './ajax/AjaxDays.php',
            type: 'POST',
            data: {
                action: 'remove_all_days'
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
        let day_id = $(this).data('day_id'),
            i_order = $(this).data('i_order'),
            players_number = $(this).data('players_number');
        $.ajax({
            url: './ajax/AjaxRounds.php',
            type: 'POST',
            data: {
                action: 'insert_round',
                day_id: day_id,
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
            let day_id = $(this).data('day_id');
            let round_id = $(this).data('round_id');
            $.ajax({
                url: './ajax/AjaxRounds.php',
                type: 'POST',
                data: {
                    action: 'remove_round',
                    day_id: day_id,
                    round_id: round_id
                },
                success: function(r) {
                    location.reload(true);
                },
                error : function(r) {
                    alert('plop' + r.error)
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

    // Ajout des équipes d'une manche
    $(document).ready(function() {
        $('[id*="teams-list-"]').each(function() {
            let round_ready = $(this).data('round_ready'),
                day_id = $(this).data('day_id'),
                round_id = $(this).data('round_id');
            if(round_ready == '') {
                $.ajax({
                    url: './ajax/AjaxTeams.php',
                    type: 'POST',
                    data: {
                        action: 'insert_teams',
                        day_id: day_id,
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
    $(document).ready(function() {
        $('[id*="matches-list-"]').each(function() {
            let teams_ready = $(this).data('teams_ready'),
                matches_ready = $(this).data('matches_ready'),
                day_id = $(this).data('day_id'),
                round_id = $(this).data('round_id');
            if(teams_ready != '0' && matches_ready == '') {
                $.ajax({
                    url: './ajax/AjaxMatches.php',
                    type: 'POST',
                    data: {
                        action: 'insert_matches',
                        day_id: day_id,
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

    // Valider les scores
    $('[id*="submit-scores-"]').each(function() {
        $(this).on('click', function() {
            let score_status = $(this).data('score_status');
            let id = $(this).closest('.match-scores').data('match_id'),
                score_1 = $(this).closest('.match-scores').find('input[name="score-1"]').val(),
                score_2 = $(this).closest('.match-scores').find('input[name="score-2"]').val();
            $.ajax({
                url: './ajax/AjaxMatches.php',
                type: 'POST',
                data: {
                    action: 'insert_scores',
                    score_status: score_status,
                    id: id,
                    score_1: score_1,
                    score_2: score_2
                },
                success: function() {
                    location.reload(true);
                }
            });
        });
    });

    // Éditer les scores
    $('[id*="edit-scores-"]').each(function() {
        $(this).on('click', function() {
            let score_status = $(this).data('score_status'),
                id = $(this).closest('.match-scores').data('match_id');
                $.ajax({
                    url: './ajax/AjaxMatches.php',
                    type: 'POST',
                    data: {
                        action: 'edit_scores',
                        id: id,
                        score_status: score_status
                    },
                    success: function() {
                        location.reload(true);
                    }
                });
        });
    });
});