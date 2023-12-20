$(document).ready(function() {

    // Valider les scores
    $('[id*="submit-scores-"]').each(function() {
        $(this).on('click', function() {
            let score_status = $(this).data('score_status'),
                id = $(this).closest('.match-scores').data('match_id'),
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
                success: function() {location.reload(true);}
            });
            let player_1_0_id = $(this).parent().find('[data-team-1_0]').data['player_1_0_id'],
                player_1_2_id = $(this).parent().find('[data-team-1_2]').data['player_1_2_id'],
                player_1_4_id = $(this).parent().find('[data-team-1_4]').data['player_1_4_id'],
                player_2_0_id = $(this).parent().find('[data-team-2_0]').data['player_2_0_id'],
                player_2_2_id = $(this).parent().find('[data-team-2_2]').data['player_2_2_id'],
                player_2_4_id = $(this).parent().find('[data-team-2_4]').data['player_2_4_id'];
            $.ajax({
                url: './ajax/AjaxPlayers.php',
                type: 'POST',
                data: {
                    action: 'update_players_score',
                    match_id: id,
                    player_1_0_id: player_1_0_id,
                    player_1_2_id: player_1_2_id,
                    player_1_4_id: player_1_4_id,
                    player_2_0_id: player_2_0_id,
                    player_2_2_id: player_2_2_id,
                    player_2_4_id: player_2_4_id,
                    score_1: score_1,
                    score_2: score_2
                },
                success: function() {}
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


