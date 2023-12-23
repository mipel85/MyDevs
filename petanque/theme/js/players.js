$(document).ready(function() {

    $('[id*="submit-scores-"]').each(function() {
        $(this).on('click', function() {
            let score_status = $(this).data('score_status'),
                player_score_status = !$(this).data('score_status'),
                day_id = $(this).closest('.match-scores').data('day_id'),
                round_id = $(this).closest('.match-scores').data('round_id'),
                match_id = $(this).closest('.match-scores').data('match_id'),
                score_1 = $(this).closest('.match-scores').find('input[name="score-1"]').val(),
                score_2 = $(this).closest('.match-scores').find('input[name="score-2"]').val();
            // Get players id and name from both teams
            let player_a0_id = $(this).closest('.match-scores').find('[data-team_a0]').data('member_id'),
                player_a0_name = $(this).closest('.match-scores').find('[data-team_a0]').text(),
                player_a2_id = $(this).closest('.match-scores').find('[data-team_a2]').data('member_id'),
                player_a2_name = $(this).closest('.match-scores').find('[data-team_a2]').text(),
                player_a4_id = $(this).closest('.match-scores').find('[data-team_a4]').data('member_id'),
                player_a4_name = $(this).closest('.match-scores').find('[data-team_a4]').text(),
                player_b0_id = $(this).closest('.match-scores').find('[data-team_b0]').data('member_id'),
                player_b0_name = $(this).closest('.match-scores').find('[data-team_b0]').text(),
                player_b2_id = $(this).closest('.match-scores').find('[data-team_b2]').data('member_id'),
                player_b2_name = $(this).closest('.match-scores').find('[data-team_b2]').text(),
                player_b4_id = $(this).closest('.match-scores').find('[data-team_b4]').data('member_id'),
                player_b4_name = $(this).closest('.match-scores').find('[data-team_b4]').text();
            // Insert member in `rankings` table
            $.ajax({
                url: './ajax/AjaxRankings.php',
                type: 'POST',
                data: {
                    action: 'insert_rank',
                    day_id: day_id,
                    player_a0_id: player_a0_id,
                    player_a0_name: player_a0_name,
                    player_a2_id: player_a2_id,
                    player_a2_name: player_a2_name,
                    player_a4_id: player_a4_id,
                    player_a4_name: player_a4_name,
                    player_b0_id: player_b0_id,
                    player_b0_name: player_b0_name,
                    player_b2_id: player_b2_id,
                    player_b2_name: player_b2_name,
                    player_b4_id: player_b4_id,
                    player_b4_name: player_b4_name,
                },
                success: function() {
                    // Insert member in `players` table
                    $.ajax({
                        url: './ajax/AjaxPlayers.php',
                        type: 'POST',
                        data: {
                            action: 'insert_player',
                            day_id: day_id,
                            round_id: round_id,
                            match_id: match_id,
                            player_a0_id: player_a0_id,
                            player_a0_name: player_a0_name,
                            player_a2_id: player_a2_id,
                            player_a2_name: player_a2_name,
                            player_a4_id: player_a4_id,
                            player_a4_name: player_a4_name,
                            player_b0_id: player_b0_id,
                            player_b0_name: player_b0_name,
                            player_b2_id: player_b2_id,
                            player_b2_name: player_b2_name,
                            player_b4_id: player_b4_id,
                            player_b4_name: player_b4_name,
                        },
                        success: function() {
                            // Update players score in `players` table
                            $.ajax({
                                url: './ajax/AjaxPlayers.php',
                                type: 'POST',
                                data: {
                                    action: 'update_players_score',
                                    match_id: match_id,
                                    player_a0_id: player_a0_id,
                                    player_a2_id: player_a2_id,
                                    player_a4_id: player_a4_id,
                                    player_b0_id: player_b0_id,
                                    player_b2_id: player_b2_id,
                                    player_b4_id: player_b4_id,
                                    player_score_status: score_status,
                                    score_1: score_1,
                                    score_2: score_2
                                },
                                success: function() {
                                    // Insert scores in `matches` table
                                    $.ajax({
                                        url: './ajax/AjaxMatches.php',
                                        type: 'POST',
                                        data: {
                                            action: 'insert_scores',
                                            day_id: day_id,
                                            score_status: score_status,
                                            match_id: match_id,
                                            score_1: score_1,
                                            score_2: score_2
                                        },
                                        success: function() {
                                            location.reload(true);
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });
    });

    // Éditer les scores
    $('[id*="edit-scores-"]').each(function() {
        $(this).on('click', function() {
            let score_status = $(this).data('score_status'),
                match_id = $(this).closest('.match-scores').data('match_id');
                $.ajax({
                    url: './ajax/AjaxMatches.php',
                    type: 'POST',
                    data: {
                        action: 'edit_scores',
                        match_id: match_id,
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
                window.location.replace('index.php?page=rankings');
            }
        });
    });
});


