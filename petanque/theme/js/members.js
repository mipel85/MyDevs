$(document).ready(function() {
    $('#member_name').focus();
    $('#member_name').removeClass('is_empty');

    // DataTable
    $('#registred-members').DataTable(
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
});


