<script type="text/javascript" src="{PATH_TO_ROOT}/LamTools/templates/DataTables/js/jquery.dataTables.min.js"></script>

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
    # IF C_CONTROLS #{"width": "14%"}# ENDIF #
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


<script>
    jQuery("input[name^='payment']").on('click', function() {
        var amount_paid = jQuery(this).closest('tr').find('td:eq(5)').text();
        var id = jQuery(this).attr('id');
        var club_name = jQuery(this).attr('value');
        jQuery.ajax({
            url: '${relative_url(ToolsUrlBuilder::payment_validation())}',
            type: "post",
            dataType: "json",
            data: {
                token: '{TOKEN}',
                id: id,
                amount_paid: amount_paid
            },
            success: function(returnData) {
                jQuery('#info').html(returnData.msg);
                jQuery('#info').show();
                jQuery('#info').delay(2000).fadeOut();
                jQuery('#requests').load(location.href + " #requests");
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(e) {
            }
        });
    });
</script>

<section id="module-lamfinancial">
    <header class="section-header">
        <h1>{@lamfinancial.pending.requests}</h1>
    </header>
    <div class="sub-section">
        <div class="content-container responsive-table">
            <div id="info" class = "payment-validation"></div>
            # IF C_ITEMS #
                <table id="requests" class="display">
                    <thead>
                        <tr>
                            <th>{@lamfinancial.form.radio.choices}</th>
                            <th>{@lamfinancial.club.name}</th>
                            <th>{@lamfinancial.club.ffam.number}</th>
                            <th>{@lamfinancial.club.activity.date}</th>
                            <th>{@lamfinancial.club.request.date}</th>
                            <th>{@lamfinancial.amount.paid}</th>
                            # IF C_CONTROLS #<th>{@lamfinancial.club.payment}</th># ENDIF #
                        </tr>
                    </thead>
                    <tbody>
                        # START pending_requests #
                            <tr>
                                <td>{pending_requests.ACTIVITY_TYPE}</td>
                                <td>{pending_requests.CLUB_NAME}</td>
                                <td>{pending_requests.CLUB_FFAM_NUMBER}</td>
                                <td>{pending_requests.CLUB_ACTIVITY_DATE}</td>
                                <td>{pending_requests.CLUB_REQUEST_DATE}</td>
                                <td>{pending_requests.AMOUNT_PAID}</td>
                                # IF C_CONTROLS #
                                    <td><input id="{pending_requests.CHECKBOX_ID}" type="checkbox" name="payment" aria-label="{@lamfinancial.club.payment}" value="{pending_requests.ACTIVITY_TYPE} de {pending_requests.CLUB_NAME}" /></td>
                                # ENDIF #
                            </tr>
                        # END pending_requests #
                    </tbody>
                </table>
            # ELSE #
                <sapn class="message-helper bgc notice">{@lamfinancial.no.current.items}</sapn>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>