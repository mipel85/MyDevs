$(document).ready(function() {

// Config ###########################################################################
    $('#add-member-name').focus();
    $('#add-member-name').removeClass('full-error');
    rowtocolumn('#registred-members-list', '.row-item', 'row-col', 5);

    // Add new member
    $('#add-member').on('click', function() {
        var name = $('#add-member-name').val();
        if (name !== ''){
            $.ajax({
                url: './ajax/AjaxMembers.php',
                type: 'POST',
                data: {
                    action: 'insert_member',
                    name: name
                },
                success: function(r) {
                    $('#add-member-name').val('');
                    location.reload(true);
                    $('#add-member-name').focus();
                },
                error: function(r) {
                    alert(r.error);
                }
            });
        } else {
            alert('Le nom du joueur doit être renseigné');
            $('#add-member-name').addClass('full-error');
            $('#add-member-name').on('keyup', function(){ $(this).removeClass('full-error') })
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
    // Select/unselect members as favourite
    $('.change-name').each(function() {
        $(this).on('click', function() {
            let id = $(this).data('member_id'),
                name = $(this).prev().val();
            if ($(this).hasClass('edit-button')) {
                $(this).prev().removeAttr('readonly').addClass('bgc-notice');
                $(this).removeClass('edit-button')
                    .addClass('change-button')
                    .html('<i class="far fa-lg fa-square-caret-right notice"></i>');
            } else if ($(this).hasClass('change-button')) {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'change_name',
                        id: id,
                        name: name,
                    },
                    success: function() {
                        location.reload(true);
                    }
                });
            }
        });
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
                        action: 'set_member_fav',
                        id: id
                    },
                    success: function() {location.reload(true);}
                });
            }else{
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'reset_member_fav',
                        id: id
                    },
                    success: function() {location.reload(true);}
                });
            }
        });
    });

    // désélectionner tous les favoris
    $('#select-all-favs').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'select_all_favs'
            },
            success: function(data) {location.reload(true);}
        });
    });

    // Set all members to fav = 0
    $('#reset-all-favs').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'reset_all_members_fav'
            },
            success: function(data) {location.reload(true);}
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
                        action: 'select_member',
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
                        action: 'unselect_member',
                        id: id
                    },
                    success: function() {location.reload(true);},
                    error: function() {console.log('fail')}
                })
            }
        });
    });

    // Reset all members as absent
    $('#unselect-all-members').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'unselect_all_members'
            },
            success: function(data) {
                location.reload(true);
            }
        });
    });

    // Reset all members as absent
    $('#select-all-members').on('click', function() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'select_all_members'
            },
            success: function(data) {
                location.reload(true);
            }
        });
    });
    
    // Display list of selected members
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
});


