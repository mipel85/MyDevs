$(document).ready(function() {
    $('#player_name').focus();
    $('#player_name').removeClass('is_empty');

    // DataTable
    $('#table_joueurs_connus').DataTable(
        {
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
                {orderable: false}
            ]
        }
    );

    // Select/unselect players as favourite
    $('#table_joueurs_connus').on('change', "input.btn-fav-joueur", function() {
        var id = $(this).attr('data-id');
        if ((this.checked)){
            $.ajax({
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'favory',
                    id: id
                },
                success: function() {}
            });
        }else{
            $.ajax({
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'anonyme',
                    id: id
                },
                success: function() {}
            });
        }
    });

    // désélectionner tous les favoris
    $('#btn_reset_favs').on('click', function() {
        $.ajax({
            url: './ajax/AjaxPlayer.php',
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
        var player_name = $('#player_name').val();
        if (player_name !== ''){
            $.ajax({
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'insert',
                    player_name: player_name
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
                url: './ajax/AjaxPlayer.php',
                type: 'POST',
                data: {
                    action: 'sup',
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


