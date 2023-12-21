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
                success: function() {
                    location.reload(true);
                }
            });
            let player_a0_id = $(this).closest('.match-scores').find('[data-team_a0]').data('member_id'),
                player_a2_id = $(this).closest('.match-scores').find('[data-team_a2]').data('member_id'),
                player_a4_id = $(this).closest('.match-scores').find('[data-team_a4]').data('member_id'),
                player_b0_id = $(this).closest('.match-scores').find('[data-team_b0]').data('member_id'),
                player_b2_id = $(this).closest('.match-scores').find('[data-team_b2]').data('member_id'),
                player_b4_id = $(this).closest('.match-scores').find('[data-team_b4]').data('member_id'),
                player_score_status = (score_1 != score_2) ? 1 : 0;
            $.ajax({
                url: './ajax/AjaxPlayers.php',
                type: 'POST',
                data: {
                    action: 'update_players_score',
                    match_id: id,
                    player_a0_id: player_a0_id,
                    player_a2_id: player_a2_id,
                    player_a4_id: player_a4_id,
                    player_b0_id: player_b0_id,
                    player_b2_id: player_b2_id,
                    player_b4_id: player_b4_id,
                    player_score_status: player_score_status,
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

    // Update rankings
    $('#update-rankings').on('click', function() {
        $.ajax({
            url: './ajax/AjaxRankings.php',
            type: 'POST',
            data: {
                action: 'update_rankings'
            },
            success: function() {
                // location.reload(true);
                // window.location.replace('index.php?page=rankings');
            }
        });
    });
});


