$(document).ready(function() {
    // DataTable
    $('#table_select_joueurs').DataTable({
        dom: 'lfrip<t>B',
        buttons: [
            'print'
        ],
        language: {
            url: './theme/js/lib/language.json'
        },
        "aLengthMenu": [10, 20, 30, 50],
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
    $('#table_select_joueurs').on('change', "input.checkbox-choix-joueur", function() {
        var id = $(this).prop('id');
        if ((this.checked)){
            $.ajax({
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'present',
                    id: id
                },
                success: function() {}
            });
        }else{
            $.ajax({
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'absent',
                    id: id
                },
                success: function() {}
            });
        }
    });

    // Reset all players as absent
    $('#reset-all-players').on('click', function() {
        $.ajax({
            url: './ajax/AjaxPlayer.php',
            type: 'POST',
            data: {
                action: 'reset_all_presents'
            },
            success: function(data) {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                $('#table_joueurs_presents').html('');
            }
        });
    });

    //  Display the list of present players
    function view_joueurs_presents() {
        $.ajax({
            url: './ajax/AjaxPlayer.php',
            type: 'POST',
            data: {
                action: 'liste-joueurs'
            },
            success: function(data) {
                $('#table_joueurs_connus').html(data);
            }
        });
    }

});


