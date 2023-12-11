$(document).ready(function() {
    $('#player_name').focus();
    $('#player_name').removeClass('is_empty');

    // DataTable
    $('#registred-players').DataTable(
        {
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
                {orderable: false}
            ]
        }
    );

    // Select/unselect players as favourite
    $('.fav-player').each(function() {
        $(this).on('change', function() {
            var id = $(this).data('id');
            if ((this.checked)){
                $.ajax({
                    url: './ajax/AjaxPlayers.php',
                    type: 'POST',
                    data: {
                        action: 'favory',
                        id: id
                    },
                    success: function() {}
                });
            }else{
                $.ajax({
                    url: './ajax/AjaxPlayers.php',
                    type: 'POST',
                    data: {
                        action: 'anonyme',
                        id: id
                    },
                    success: function() {}
                });
            }
        });
    });

    // désélectionner tous les favoris
    $('#reset-all-favs').on('click', function() {
        $.ajax({
            url: './ajax/AjaxPlayers.php',
            type: 'POST',
            data: {
                action: 'reset_all_favs'
            },
            success: function(data) {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                $('#table_joueurs_presents').html('');
            }
        });
    });

    // Add new player
    $('#add-player').on('click', function() {
        var name = $('#player_name').val();
        if (name !== ''){
            $.ajax({
                url: './ajax/AjaxPlayers.php',
                type: 'POST',
                data: {
                    action: 'insert_player',
                    name: name
                },
                success: function(r) {
                    $('#player_name').val('');
                    $('#player_name').removeClass('is_empty');
                    location.reload(true);
                    $('#player_name').focus();
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        }else{
            alert('Le nom du joueur doit être renseigné');
            $('#player_name').focus();
            $('#player_name').addClass('is_empty');
        }
    });

    // Remove player
    $(".delete-player").each(function() {
        $(this).on('click', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: './ajax/AjaxPlayers.php',
                type: 'POST',
                data: {
                    action: 'remove_player',
                    id: id
                },
                success: function(r) {
                    location.reload(true);
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        });
    });
});


