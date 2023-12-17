$(document).ready(function() {

    // Config ###########################################################################
    $('#member_name').focus();
    $('#member_name').removeClass('is_empty');

    // DataTable
    $('#registred-members').DataTable({
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
            {type: "text"},
            {orderable: false}
        ]
    });

    // Add new member
    $('#add-member').on('click', function() {
        var name = $('#member_name').val();
        if (name !== ''){
            $.ajax({
                url: './ajax/AjaxMembers.php',
                type: 'POST',
                data: {
                    action: 'insert_member',
                    name: name
                },
                success: function(r) {
                    $('#member_name').val('');
                    $('#member_name').removeClass('is_empty');
                    location.reload(true);
                    $('#member_name').focus();
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        }else{
            alert('Le nom du joueur doit être renseigné');
            $('#member_name').focus();
            $('#member_name').addClass('is_empty');
        }
    });

    // Remove member
    $(".remove-member").each(function() {
        $(this).on('click', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: './ajax/AjaxMembers.php',
                type: 'POST',
                data: {
                    action: 'remove_member',
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

    // Front ###########################################################################
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
                url: './ajax/AjaxMembers.php',
                type: 'POST',
                data: {
                    action: 'selected_members'
                },
                dataType: "json",
                success: function(responseJson) {
                    $('#selected-members-list').html('');
                    $.each(responseJson.selected_player, function(key, value) {
                        $('<div/>', {class : 'selected-member'}).html(value['name']).appendTo('#selected-members-list');
                    });
                    let count = $('.selected-member').length;
                    console.log(count);
                    $('.selected-number').html(count + ' joueurs sélectionnés');
                    if (count == 7) {
                        $('#error-7').removeClass('hidden');
                    }
                    else {
                        $('#error-7').addClass('hidden');
                    }
                    if (count < 4) {
                        $('#error-4').removeClass('hidden');
                    }
                    else {
                        $('#error-4').addClass('hidden');
                    }
                }
            });
        });
    });
    
    // Display list of selected players
    $('#display-selected-members').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'selected_members'
            },
            dataType: "json",
            success: function(responseJson) {
                $('#selected-members-list').html('');
                $.each(responseJson.selected_players, function(key, value) {
                    $('<div/>', {class : 'selected-member'}).html(value['name']).appendTo('#selected-members-list');
                });
                let count = responseJson.selected_players.length;
                if (count == 1)
                    $('.selected-number').html(count + ' joueur sélectionné');
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
    
    // Display list of members 
    // $.ajax({
    //     url: './ajax/AjaxMembers.php',
    //     type: 'POST',
    //     data: {
    //         action: 'members_list'
    //     },
    //     dataType: "json",
    //     success: function(responseJson) {
    //         $('#display-members-list').html('');
    //         $.each(responseJson.members, function(key, value) {
    //             let id = value['id'],
    //                 fav_icon = value['fav'] ?  '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>',
    //                 present_icon = value['present'] ?  '<i class="fa fa-sm fa-check"></i>' : '';
                
    //             $('<div/>', {'data-id' : id, class : 'display-member-row'}).appendTo('#display-members-list');
    //             $('<div/>', {id: 'present-' + id, class: 'present-checkbox'}).appendTo('[data-id="'+id+'"]');
    //             $('<label/>', {id: 'label-present' + id, for: 'present-' + id, class: 'checkbox'}).appendTo('#present-'+id);
    //             $('<input/>', {id: 'present-' + id, type: 'checkbox', class: 'present-member', checked: value['present']}).appendTo('#label-present'+id);
    //             $('<span/>').html(present_icon).appendTo('#label-present'+id);
    //             $('<div/>', {id: 'fav-' + id, class: 'fav-checkbox'}).appendTo('[data-id="'+id+'"]');
    //             $('<label/>', {id: 'label-fav-' + id, for: 'fav-' + id, class: 'checkbox'}).appendTo('#fav-'+id);
    //             $('<input/>', {id: 'fav-' + id, type: 'checkbox', class: 'fav-member', checked: value['fav']}).appendTo('#label-fav-'+id);
    //             $('<span/>').html(fav_icon).appendTo('#label-fav-'+id);
    //             $('<div/>', {class: 'flex-main'}).html(value['name']).appendTo('[data-id="'+id+'"]');
    //             $('<div/>', {class: 'small'}).html(value['id']).appendTo('[data-id="'+id+'"]');
    //         });
    //         let count = responseJson.members.length;
    //         $('.selected-number').html(count + ' joueurs sélectionnés');
    //     }
    // });
});


