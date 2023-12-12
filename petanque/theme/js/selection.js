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
    });

    // Select/unselect member as present/absent
    $('.select-member').each(function(){
        $(this).on('change', function() {
            var id = $(this).prop('id');
            if ((this.checked)) {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
                    type: 'POST',
                    data: {
                        action: 'present',
                        id: id
                    },
                    success: function() {}
                });
            } else {
                $.ajax({
                    url: './ajax/AjaxMembers.php',
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
            }
        });
    });

    //  Display the list of present members
    function show_present_members() {
        $.ajax({
            url: './ajax/AjaxMembers.php',
            type: 'POST',
            data: {
                action: 'members_list'
            },
            success: function(data) {
                $('#table_joueurs_connus').html(data);
            }
        });
    }

});


