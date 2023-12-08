$(document).ready(function() {
    // DataTable
    $('#players-list').DataTable({
        dom: 'lfrip<t>B',
        buttons: [
            'print'
        ],
        language: {
            url: './theme/js/lib/language.json'
        },
        "aLengthMenu": [
            [10, 20, 30, 50, -1],
            [10, 20, 30, 50, 'Tous']
    ],
        "paginationType": "simple_numbers",
        "pageLength": 10,
        "fixedHeader": true,
        "paging": true,
        "columns": [
            {type: "num"},
            {type: "text"},
            {type: "text"},
            {orderable: true}
        ]
    });

    // Select/unselect player as present/absent
    $('.select-player').each(function(){
        $(this).on('change', function() {
            var id = $(this).prop('id');
            if ((this.checked)) {
                $.ajax({
                    url: './ajax/AjaxPlayers.php',
                    type: 'POST',
                    data: {
                        action: 'present',
                        id: id
                    },
                    success: function() {}
                });
            } else {
                $.ajax({
                    url: './ajax/AjaxPlayers.php',
                    type: 'POST',
                    data: {
                        action: 'absent',
                        id: id
                    },
                    success: function() {}
                });
            }
        })
    });

    // Reset all players as absent
    $('#reset-all-players').on('click', function() {
        $.ajax({
            url: './ajax/AjaxPlayers.php',
            type: 'POST',
            data: {
                action: 'reset_all_presents'
            },
            success: function(data) {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                $('#selected-players').html('');
            }
        });
    });

    //  Display the list of present players
    function show_present_players() {
        $.ajax({
            url: './ajax/AjaxPlayers.php',
            type: 'POST',
            data: {
                action: 'players_list'
            },
            success: function(data) {
                $('#table_joueurs_connus').html(data);
            }
        });
    }

});


