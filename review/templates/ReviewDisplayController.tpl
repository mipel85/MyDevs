<script type="text/javascript" src="{PATH_TO_ROOT}/review/templates/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{PATH_TO_ROOT}/review/templates/DataTables/js/fixedHeader.min.js"></script>

<script>
    jQuery(document).ready(function() {
    // Setup - add a text input to each footer cell
    jQuery('.display thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('.display thead');
        var table = jQuery('.display').DataTable({
            "sDom": '<"top">lfi<"bottom"pt><"clear">',
            language: {
                "sInfo": ${escapejs(@review.js.info)},
                "sInfoEmpty": ${escapejs(@review.js.info.empty)},
                "sInfoFiltered": ${escapejs(@review.js.info.filtered)},
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": ${escapejs(@review.js.length.menu)},
                "sLoadingRecords": ${escapejs(@review.js.loading.records)},
                "sProcessing": ${escapejs(@review.js.processing)},
                "sSearch": ${escapejs(@review.js.search)},
                "sZeroRecords": ${escapejs(@review.js.zero.records)},
                "oPaginate": {
                    "sFirst": ${escapejs(@review.js.first)},
                    "sLast": ${escapejs(@review.js.last)},
                    "sNext": ${escapejs(@review.js.next)},
                    "sPrevious": ${escapejs(@review.js.previous)}
                },
                "oAria": {
                    "sSortAscending": ${escapejs(@H|review.js.sort.asc)},
                    "sSortDescending": ${escapejs(@H|review.js.sort.desc)}
                }
            },
            "aLengthMenu":[15, 25, 50, 100],
            "sPaginationType": "full_numbers",
            "sScrollY": "auto",
            "iDisplayLength": 15,

            orderCellsTop: true,
            fixedHeader: true,
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
                    jQuery(cell).html('<input type="text" placeholder="' + title + '" />');
                    // On every keypress in this input
                    jQuery(
                            'input',
                            jQuery('.filters th').eq(jQuery(api.column(colIdx).header()).index())
                    )
                    .off('keyup change')
                    .on('keyup change', function(e) {
                        e.stopPropagation();
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
                });
            },
        });
    });
</script>

<section id="admin-contents">
    # INCLUDE REVIEW_COUNTERS #

    # IF C_FILES_ON_SERVER #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.files.on.server}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START onserver #
                            <tr>
                                # IF onserver.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {onserver.FILE_ON_SERVER}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{onserver.FILE_ON_SERVER}" /></span>
                                    </td>
                                # ELSE #
                                    # IF onserver.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {onserver.FILE_ON_SERVER}<span class="review-preview"><i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/upload/{onserver.FILE_ON_SERVER}" /></span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {onserver.FILE_ON_SERVER}<span class="review-preview"><i class="fa fa-eye-slash"></i></span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                            </tr>
                        # END onserver #
                    </tbody>
                </table>
            </div>            
        </article>
    # ENDIF #

    # IF C_FILES_IN_GALLERY_FOLDER #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.files.in.gallery.folder}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START ingalleryfolder #
                            <tr>
                                # IF ingalleryfolder.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {ingalleryfolder.FILE_IN_GALLERY_FOLDER}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/gallery/pics/{ingalleryfolder.FILE_IN_GALLERY_FOLDER}" /></span>
                                    </td>
                                # ELSE #
                                    # IF ingalleryfolder.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {ingalleryfolder.FILE_IN_GALLERY_FOLDER}<span class="review-preview"><i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/gallery/pics/{ingalleryfolder.FILE_IN_GALLERY_FOLDER}" /></span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {ingalleryfolder.FILE_IN_GALLERY_FOLDER}<span class="review-preview"><i class="fa fa-eye-slash"></i></span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                            </tr>
                        # END ingalleryfolder #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_FILES_IN_GALLERY_TABLE #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.files.in.gallery.table}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START ingallerytable #
                            <tr>
                                # IF ingallerytable.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {ingallerytable.FILE_IN_GALLERY_TABLE}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/gallery/pics/{ingallerytable.FILE_IN_GALLERY_TABLE}" /></span>
                                    </td>
                                # ELSE #
                                    # IF ingallerytable.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {ingallerytable.FILE_IN_GALLERY_TABLE}<span class="review-preview"><i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/gallery/pics/{ingallerytable.FILE_IN_GALLERY_TABLE}" /></span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {ingallerytable.FILE_IN_GALLERY_TABLE}<span class="review-preview"><i class="fa fa-eye-slash"></i></span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                            </tr>
                        # END ingallerytable #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_FILES_IN_UPLOAD #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.files.in.upload}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START inupload #
                            <tr>
                                # IF inupload.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {inupload.FILE_IN_UPLOAD}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{inupload.FILE_IN_UPLOAD}" /></span>
                                    </td>
                                # ELSE #
                                    # IF inupload.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {inupload.FILE_IN_UPLOAD}<span class="review-preview"><i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/upload/{inupload.FILE_IN_UPLOAD}" /></span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {inupload.FILE_IN_UPLOAD}<span class="review-preview"><i class="fa fa-eye-slash"></i></span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                            </tr>
                        # END inupload #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_FILES_IN_CONTENT #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.files.in.content}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                            <th>{@review.file.module.source}</th>
                            <th>{@review.file.item.link}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START incontent #
                            <tr>
                                # IF incontent.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {incontent.FILE_PATH}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{incontent.FILE_PATH}" /></span>
                                    </td>
                                # ELSE #
                                    # IF incontent.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {incontent.FILE_PATH}<span class="review-preview"><i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/upload/{incontent.FILE_PATH}" /></span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {incontent.FILE_PATH}<span class="review-preview"><i class="fa fa-eye-slash"></i></span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                                <td>
                                    {incontent.FILE_MODULE_SOURCE}
                                </td>
                                <td>
                                    # IF incontent.C_FILE_ITEM_TITLE #
                                        <a href="{incontent.FILE_ITEM_LINK}">{incontent.FILE_ITEM_TITLE}</a>
                                    # ELSE #
                                        {@review.file.undetermined.link}
                                    # ENDIF #
                                </td>
                            </tr>
                        # END incontent #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_ALL_UNUSED_FILES #
        <article class="review-results">
            <header>
                <h2>{@review.counters.title.all.unused.files}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START allunused #
                            <tr>
                                # IF allunused.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {allunused.FILE_PATH}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{allunused.FILE_PATH}"></span>
                                    </td>
                                # ELSE #
                                    <td class="flex-between">
                                        {allunused.FILE_PATH}<span class="review-preview"><i  class="fa fa-eye-slash"></i></span>
                                    </td>
                                # ENDIF #
                            </tr>
                        # END allunused #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_USED_FILES_NOT_ON_SERVER #
        <article class="review-results">
            <header>
                <h2>{@review.counters.used.files.no.server}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                            <th>{@review.file.module.source}</th>
                            <th>{@review.file.item.link}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START usednoserver #
                            <tr>
                                <td>
                                    {usednoserver.FILE_PATH}
                                </td>
                                <td>
                                    {usednoserver.FILE_MODULE_SOURCE}
                                </td>
                                <td>
                                    # IF usednoserver.C_FILE_ITEM_TITLE #
                                        <a href="{usednoserver.FILE_ITEM_LINK}">{usednoserver.FILE_ITEM_TITLE}</a>
                                    # ELSE #
                                        {@review.file.undetermined.link}
                                    # ENDIF #
                                </td>
                            </tr>
                        # END usednoserver #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_UNUSED_FILES_USER #
        <article class="review-results">
            <header>
                <h2>{@review.counters.unused.files.users}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                            <th>{@review.file.upload.by}</th>
                            <th>{@review.file.timestamp}</th>
                            <th>{@review.file.size}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START unuseduser #
                            <tr>
                                <td class="flex-between">
                                    {unuseduser.FILE_PATH}<span class="review-preview"><i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{unuseduser.FILE_PATH}"></span>
                                </td>
                                <td>
                                    {unuseduser.FILE_USER}
                                </td>
                                <td>
                                    {unuseduser.FILE_UPLOAD_DATE}
                                </td>
                                <td>
                                    {unuseduser.FILE_SIZE}
                                </td>
                            </tr>
                        # END unuseduser #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_ORPHAN_FILES #
        <article class="review-results">
            <header>
                <h2>{@review.counters.orphan.files}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START orphan #
                            <tr>
                                # IF orphan.C_IS_PICTURE_FILE #
                                    <td class="flex-between">
                                        {orphan.FILE_PATH}
                                        <span class="review-preview">
                                            <i class="fa fa-eye"></i>
                                            <img src="{PATH_TO_ROOT}/upload/{orphan.FILE_PATH}">
                                        </span>
                                    </td>
                                # ELSE #
                                    # IF orphan.C_IS_PDF_FILE #
                                        <td class="flex-between">
                                            {orphan.FILE_PATH}
                                            <span class="review-preview">
                                                <i class="fa fa-eye"></i>
                                                <embed src="{PATH_TO_ROOT}/upload/{orphan.FILE_PATH}">
                                            </span>
                                        </td>
                                    # ELSE #
                                        <td class="flex-between">
                                            {orphan.FILE_PATH}
                                            <span class="review-preview">
                                                <i class="fa fa-eye-slash"></i>
                                            </span>
                                        </td>
                                    # ENDIF #
                                # ENDIF #
                            </tr>
                        # END orphan #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_FILES_NOT_IN_GALLERY_FOLDER #
        <article class="review-results">
            <header>
                <h2>{@review.counters.files.no.gallery.folder}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START nogalleryfolder #
                            <tr>
                                <td class="flex-between">{nogalleryfolder.FILE_PATH}</td>
                            </tr>
                        # END nogalleryfolder #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #

    # IF C_FILES_NOT_IN_GALLERY_TABLE #
        <article class="review-results">
            <header>
                <h2>{@review.counters.files.no.gallery.table}</h2>
            </header>
            <div class="content">
                <table class="display review-table">
                    <thead>
                        <tr>
                            <th>{@review.file.path}</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START nogallerytable #
                            <tr>
                                <td class="flex-between">{nogallerytable.FILE_PATH}</td>
                            </tr>
                        # END nogallerytable #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #
    <footer></footer>
</section>
