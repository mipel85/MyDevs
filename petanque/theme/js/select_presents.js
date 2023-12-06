$(document).ready(function() {
    $('#table_joueurs_connus').DataTable(
            {
                dom: 'lfrip<t>B',
                buttons: [
                    'print'
                ],
                language: {
                    url: './js/lib/language.json'
                },
                "aLengthMenu": [20, 30, 50],
                "paginationType": "simple_numbers",
                "pageLength": 25,
                "fixedHeader": true,
                "paging": true,
                "retrieve": true,
                "columns": [
                    {type: "num"},
                    {type: "text"},
                    {orderable: false}
                ]
            }
    );

    $('#table_joueurs_connus').on('change', "input.checkbox-choix-joueur", function() {
        var id = $(this).prop('id');
        if ((this.checked)){
            $.ajax({
                url: './ajax/actions.php',
                type: 'POST',
                data: {
                    action: 'present',
                    id: id
                },
                success: function() {
                    // location.reload();
                }
            });
        }else{
            $.ajax({
                url: './ajax/actions.php',
                type: 'POST',
                data: {
                    action: 'absent',
                    id: id
                },
                success: function() {
                    // location.reload();
                }
            });
        }
    });

    // reset checkbox
    $('#btn_reset_present').on('click', function() {
        $.ajax({
            url: './ajax/actions.php',
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

});


