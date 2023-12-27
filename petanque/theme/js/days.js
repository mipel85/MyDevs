$(document).ready(function() {

    // Init day
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
            success: function() {
                location.reload(true);
            }
        });
    }

    // Remove one day
    $(".remove-day").each(function() {
        $(this).on('click', function() {
            let id = $(this).attr('id');
            $.ajax({
                url: './ajax/AjaxDays.php',
                type: 'POST',
                data: {
                    action: 'remove_day',
                    day_id: id
                },
                success: function() {
                    location.reload(true);
                }
            });
        });
    });

    // Remove all days
    $("#remove-all-days").on('click', function() {
        $.ajax({
            url: './ajax/AjaxDays.php',
            type: 'POST',
            data: {
                action: 'remove_all_days'
            },
            success: function() {
                location.reload(true);
            }
        });
    });
    
    // Select/unselect playgrounds
    $('.checkbox-field').each(function() {
        $(this).on('change', function() {
            let fields_id = $(this).data('fields_id'),
                field_id = $(this).attr('id');
            if ($(this).is(':checked')) {
                $.ajax({
                    url: './ajax/AjaxDays.php',
                    type: 'POST',
                    data: {
                        action: 'check_field',
                        fields_id: fields_id,
                        field_id: field_id
                    }
                });
            } else {
                $.ajax({
                    url: './ajax/AjaxDays.php',
                    type: 'POST',
                    data: {
                        action: 'uncheck_field',
                        fields_id: fields_id,
                        field_id: field_id
                    }
                });
            }
        });
    });

    // Add one round
    $('#add-round').on('click', function() {
        let day_id = $(this).data('day_id'),
            i_order = $(this).data('i_order'),
            players_number = $(this).data('players_number'),
            redirect = window.location.href.split('#')[0]; // Get current url and remove its hash
        $.ajax({
            url: './ajax/AjaxRounds.php',
            type: 'POST',
            data: {
                action: 'insert_round',
                day_id: day_id,
                i_order: i_order,
                players_number: players_number
            },
            success: function() {
                window.location.replace(redirect);
            }
        });
    });

    // Remove one round
    $(".remove-round").each(function() {
        $(this).on('click', function() {
            let day_id = $(this).data('day_id'),
                round_id = $(this).data('round_id'),
                redirect = window.location.href.split('#')[0]; // Get current url and remove its hash
            $.ajax({
                url: './ajax/AjaxRounds.php',
                type: 'POST',
                data: {
                    action: 'remove_round',
                    day_id: day_id,
                    round_id: round_id
                },
                success: function() {
                    window.location.replace(redirect);
                }
            });
        });
    });

    // Add teams for the current round
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
                success: function() {
                    location.reload(true);
                }
            });
        }
    });

    // Add matches for the current round
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
                success: function() {
                    location.reload(true);
                }
            });
        }
    });

    // un/Set flag of the day
    $('#day-flag').on('click', function() {
        let day_id = $(this).data('day_id'),
            day_flag = $(this).data('day_flag');
        if(day_flag) {
            $.ajax({
                url: './ajax/AjaxDays.php',
                type: 'POST',
                data: {
                    action: 'disable_day',
                    day_id: day_id
                },
                success: function() {
                    location.reload(true);
                }
            });
        } else {
            $.ajax({
                url: './ajax/AjaxDays.php',
                type: 'POST',
                data: {
                    action: 'enable_day',
                    day_id: day_id
                },
                success: function() {
                    location.reload(true);
                }
            });
        }
    });
});