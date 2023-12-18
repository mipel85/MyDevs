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
            var id = $(this).data('fav_id');
            if ((this.checked)){
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'favory',
                        id: id
                    },
                    success: function() {location.reload(true);}
                });
            }else{
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'casual',
                        id: id
                    },
                    success: function() {location.reload(true);}
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
            }
        });
    });

    // Select/unselect member as present/absent
    // and add/remove it in the list of selected players
    $('.present-member').each(function(){
        $(this).on('change', function() {
            var id = $(this).data('present_id');
            if ($(this).is(':checked')) {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'present',
                        id: id
                    },
                    success: function() {location.reload(true);},
                    error: function() {console.log('fail')}
                })
            } else {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'absent',
                        id: id
                    },
                    success: function() {location.reload(true);},
                    error: function() {console.log('fail')}
                })
            }
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
    //         $.each(responseJson.members, function(key, member) {
    //             let id = member['id'],
    //                 present_icon = member['present'] ?  '<i class="fa fa-sm fa-check"></i>' : '',
    //                 present_check = member['present'] ?  'checked' : '',
    //                 fav_icon = member['fav'] ?  '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>',
    //                 fav_check = member['fav'] ?  'checked' : '';

    //             $('#display-members-list').append(
    //                 '<div class="display-member-row">' +
    //                     '<div class="present-checkbox">' +
    //                         '<label for="present-' + member['id'] + '" class="checkbox" id="label-present-' + member['id'] + '">' +
    //                             '<input data-present_id="' + member['id'] + '" type="checkbox" name="present-' + member['id'] + '" id="present-' + member['id'] + '" class="present-member" ' + present_check + ' />' +
    //                             '<span>' + present_icon + '</span>' +
    //                         '</label>' +
    //                     '</div>' +
    //                     '<div class="flex-main">' + member['name'] + '</div>' +
    //                     '<span class="small member-id">' + member['id'] + '</span>' +
    //                     '<div class="fav-checkbox">' +
    //                         '<label for="fav-' + member['id'] + '" class="checkbox" id="label-fav-' + member['id'] + '">' +
    //                             '<input data-fav_id="' + member['id'] + '" type="checkbox" name="fav-' + member['id'] + '" id="fav-' + member['id'] + '" class="fav-member" ' + fav_check + ' />' +
    //                             '<span>' + fav_icon + '</span>' +
    //                         '</label>' +
    //                     '</div>' +
    //                 '</div>'
    //             );
    //         });
    //         let count = responseJson.members.length;
    //         $('.selected-number').html(count + ' joueurs sélectionnés');
    //     }
    // });
});


