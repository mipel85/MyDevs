$(document).ready(function() {

    // Ajout d'une journée
    let init_day = $('#day-manager').data('day_ready'),
        day_date = $('#day-date').val();
    if (init_day == '') {
        $.ajax({
            url: './ajax/AjaxDays.php',
            type: 'POST',
            data: {
                action: 'insert_day',
                day_date: day_date
            },
            success: function(r) {
                location.reload(true);
            },
            error: function(r) {
                alert(r.error);
            }
        });
    }
    
    // Select/unselect playgrounds
    $('.checkbox-field').each(function() {
        $(this).on('change', function() {
            let fields_id = $(this).data('fields_id'),
                field_id = $(this).attr('id');
            if ((this.checked)){
                $.ajax({
                    url: './ajax/AjaxDays.php',
                    type: 'POST',
                    data: {
                        action: 'check_field',
                        fields_id: fields_id,
                        field_id: field_id
                    },
                    success: function() {}
                });
            } else {
                $.ajax({
                    url: './ajax/AjaxDays.php',
                    type: 'POST',
                    data: {
                        action: 'uncheck_field',
                        fields_id: fields_id,
                        field_id: field_id
                    },
                    success: function() {}
                });
            }
        });
    });

    // Supprimer une journée
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
                    // location.reload(true);
                },
                error : function(r) {
                    alert(r.error);
                }
            });
        });
    });

    // Supprimer toutes les journées
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

    // Ajout d'une partie
    $('#add-round').on('click', function() {
        let day_id = $(this).data('day_id'),
            i_order = $(this).data('i_order'),
            players_number = $(this).data('players_number'),
            redirect = window.location.href.split('#')[0];
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
                window.location.replace(redirect);
            },
            error: function(r) {}
        });
        $.ajax({
            url: './ajax/AjaxRanking.php',
            type: 'POST',
            data: {
                action: 'insert_players_list',
                day_id: day_id
            },
            success: function(r) {},
            error: function(r) {}
        });
    });

    // Supprimer une partie
    $(".remove-round").each(function() {
        $(this).on('click', function() {
            let day_id = $(this).data('day_id'),
                round_id = $(this).data('round_id'),
                round_i_order = $(this).data('round_i_order'),
                redirect = window.location.href.split('#')[0]; // Récupère l'url courrante et supprime le hash
            $.ajax({
                url: './ajax/AjaxRounds.php',
                type: 'POST',
                data: {
                    action: 'remove_round',
                    day_id: day_id,
                    round_id: round_id,
                    round_i_order: round_i_order
                },
                success: function(r) {
                    window.location.replace(redirect);
                },
                error : function(r) {
                    alert(r.error)
                }
            });
        });
    });

    // Ajout des équipes d'une partie
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

    // Ajout des rencontres d'une partie
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