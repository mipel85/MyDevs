$(document).ready(function() {
    // DataTable
    $('#members-list').DataTable({
        dom: 'lfrip<t>B',
        buttons: [
            'print'
        ],
        language: {
            url: './theme/js/lib/language.json'
        },
        "aLengthMenu": [
            [10, 20, 25, 30, 50, -1],
            [10, 20, 25, 30, 50, 'Tous']
        ],
        "paginationType": "simple_numbers",
        "pageLength": 25,
        "fixedHeader": true,
        "paging": true,
        "order": [[1, 'asc']],
        "columns": [
            {type: "num"},
            {type: "text"},
            {orderable: true},
            {orderable: true}
        ]
    });

    // Select/unselect members as favourite
    $('.fav-member').each(function() {
        $(this).on('change', function() {
            var id = $(this).data('id');
            if ((this.checked)){
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'favory',
                        id: id
                    },
                    success: function() {}
                });
            }else{
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'casual',
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
            url: './ajax/AjaxMembers.php',
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

    // Select/unselect member as present/absent
    // and add/remove it in the list of selected players
    $('.present-member').each(function(){
        $(this).on('click', function() {
            var id = $(this).data('id');
            if ((this.checked)) {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'present',
                        id: id
                    },
                    success: function() { }
                })
            } else {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'absent',
                        id: id
                    },
                    success: function() { }
                })
            }

            $.ajax({
                url: './ajax/AjaxPlayers.php',
                type: 'POST',
                data: {
                    display: 'selected_players'
                },
                dataType: "json",
                success: function(responseJson) {
                    $('#selected-members-list').html('');
                    $.each(responseJson.selected_player, function(key, value) {
                        $('<div/>', {class : 'selected-player'}).html(value['name']).appendTo('#selected-members-list');
                    });
                    let count = $('.selected-player').length;
                    $('.selected-number').html(count + ' joueurs sélectionnés');
                    if (count == 7) {
                        $('.error-7').removeClass('hidden');
                    }
                    else {
                        $('.error-7').addClass('hidden');
                    }
                    if (count < 4) {
                        $('.error-4').removeClass('hidden');
                    }
                    else {
                        $('.error-4').addClass('hidden');
                    }
                }
            });
        });
    });
    
    // Display list of selected players
    $('#display-selected-players').on('click', function() {
        $.ajax({
            url: './ajax/AjaxPlayers.php',
            type: 'POST',
            data: {
                action: '',
                display: 'selected_players'
            },
            dataType: "json",
            success: function(responseJson) {
                $('#selected-members-list').html('');
                $.each(responseJson.selected_player, function(key, value) {
                    $('<div/>', {class : 'selected-player'}).html(value['name']).appendTo('#selected-members-list');
                });
                let count = responseJson.selected_player.length;
                $('.selected-number').html(count + ' joueurs sélectionnés');
            }
        });
    });

    // Reset all members as absent
    $('#reset-all-members').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'reset_all_presents'
            },
            success: function(data) {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                $('#selected-members').html('');
                location.reload(true);
            }
        });
    });

});


