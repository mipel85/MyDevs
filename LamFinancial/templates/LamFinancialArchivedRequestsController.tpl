<script type="text/javascript" src="{PATH_TO_ROOT}/LamFinancial/templates/DataTables/js/jquery.dataTables.min.js"></script>

<script>
    jQuery('.display thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('.display thead');
    var table = jQuery('.display').DataTable({
        "sDom": '<"top">lfi<"bottom"pt><"clear">',
        language: {
            "sInfo": ${escapejs(@lamfinancial.js.info)},
            "sInfoEmpty": ${escapejs(@lamfinancial.js.info.empty)},
            "sInfoFiltered": ${escapejs(@lamfinancial.js.info.filtered)},
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": ${escapejs(@lamfinancial.js.length.menu)},
            "sLoadingRecords": ${escapejs(@lamfinancial.js.loading.records)},
            "sProcessing": ${escapejs(@lamfinancial.js.processing)},
            "sSearch": ${escapejs(@lamfinancial.js.search)},
            "sZeroRecords": ${escapejs(@lamfinancial.js.no.item)},
            "oPaginate": {
                "sFirst": ${escapejs(@lamfinancial.js.first)},
                "sLast": ${escapejs(@lamfinancial.js.last)},
                "sNext": ${escapejs(@lamfinancial.js.next)},
                "sPrevious": ${escapejs(@lamfinancial.js.previous)}
            },
            "oAria": {
                "sSortAscending": ${escapejs(@H|lamfinancial.js.sort.asc)},
                "sSortDescending": ${escapejs(@H|lamfinancial.js.sort.desc)}
            }
        },
        "aLengthMenu": [15, 25, 50, 100],
        "sPaginationType": "full_numbers",
        "sScrollY": "auto",
        "iDisplayLength": 15,
        orderCellsTop: true,
        fixedHeader: false,
        "columns": [
    {"width": "14%"},
    {"width": "14%"},
    {"width": "14%"},
    {"width": "14%"},
    {"width": "14%"},
    {"width": "14%"},
    {"width": "14%"}
        ],
        initComplete: function() {
            var api = this.api();
            // For each column
            api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = jQuery('.filters th').eq(
                                jQuery(api.column(colIdx).header()).index()
                                );
                        var title = jQuery(cell).text();
                        jQuery(cell).html('<div class="relative-search"><input class="search-input" type="text" placeholder="' + title + '" /><i class="far fa-circle-xmark error empty-search" aria-hidden="true"></i></div>');
                        // On every keypress in this input
                        var empty = jQuery('.empty-search');
                        jQuery('input', jQuery('.filters th').eq(jQuery(api.column(colIdx).header()).index()))
                                .off('keyup change')
                                .on('keyup change', function(e) {
                                    e.stopPropagation();
                                    // use empty button on input
                                    empty.addClass('visible');
                                    if (! jQuery(this).attr('title', ''))
                                        empty.removeClass('visible');
                                    // Get the search value
                                    jQuery(this).attr('title', jQuery(this).val());
                                    var regexr = '({search})'; //jQuery(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                            .column(colIdx)
                                            .search(
                                                    this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                    this.value != '',
                                                    this.value === ''
                                                    )
                                            .draw();
                                    jQuery(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        empty.on('click', function() {
                            jQuery(this).siblings().val('').attr('title', '');
                            jQuery(this).removeClass('visible');
                            api
                                    .column(colIdx)
                                    .search('')
                                    .draw();
                        });
                    });
        }
    });
</script>
<section id="module-lamfinancial">
    <header class="section-header">
        <h1>{@lamfinancial.archived.requests}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container responsive-table">
            # IF C_ITEM #
                <table id="archived_requests" class="display">
                    <thead>
                        <tr>
                            <th>{@lamfinancial.form.radio.choices}</th>
                            <th>{@lamfinancial.club.name}</th>
                            <th>{@lamfinancial.club.ffam.number}</th>
                            <th>{@lamfinancial.club.activity.date}</th>
                            <th>{@lamfinancial.club.request.date}</th>
                            <th>{@lamfinancial.amount.real.paid}</th>
                            <th>{@lamfinancial.archived.date}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START archived_requests #
                        <tr>
                            <td>{archived_requests.ACTIVITY_TYPE}</td>
                            <td>{archived_requests.CLUB_NAME}</td>
                            <td>{archived_requests.CLUB_FFAM_NUMBER}</td>
                            <td>{archived_requests.CLUB_ACTIVITY_DATE}</td>
                            <td>{archived_requests.CLUB_REQUEST_DATE}</td>
                            <td>{archived_requests.AMOUNT_PAID}</td>
                            <td>{archived_requests.ARCHIVED_DATE}</td>
                        </tr>
                        # END archived_requests #
                    </tbody>
                </table>
            # ELSE #
                <div class="message-helper bgc notice">{@lamfinancial.no.archived.items}</div>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>