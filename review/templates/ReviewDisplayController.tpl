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
            "aLengthMenu": [15, 25, 50, 100],
            "sPaginationType": "full_numbers",
            // "sScrollY": "auto",
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
            // "columnDefs": [
            //     { width: 50, targets: 5 }
            // ],
        });
    });
</script>
# INCLUDE MESSAGE_HELPER #
# INCLUDE CACHE_BUTTON #
# IF C_REVIEW_COUNTERS #
    <div class="more align-center">{@common.last.update} : {DATE}</div>
    # INCLUDE REVIEW_COUNTERS #
# ELSE #
    {@H|review.first.analyse}
# ENDIF #

# IF C_FILES_IN_UPLOAD_FOLDER #
    <article class="review-results">
        <header>
            <h2>{@review.counters.title.files.on.server}</h2>
        </header>
        <div class="content review-responsive-table">
            <table class="display review-table">
                <thead>
                    <tr>
                        <th>{@review.file.path}</th>
                        <th>{@review.file.upload.by}</th>
                        <th>{@review.file.timestamp}</th>
                        <th>{@review.file.size}</th>
                        <th aria-label="{@review.preview}"><i class="far fa-eye" aria-hidden></i></th>
                    </tr>
                </thead>
                <tbody>
                    # START inuploadfolder #
                        <tr>
                            <td class="align-left">
                                {inuploadfolder.FILE_NAME}
                            </td>
                            <td>
                                {inuploadfolder.FILE_UPLOAD_BY}
                            </td>
                            <td>
                                {inuploadfolder.FILE_UPLOAD_DATE}
                            </td>
                            <td>
                                {inuploadfolder.FILE_UPLOAD_SIZE}
                            </td>
                            <td class="align-right">
                                <span class="review-preview" aria-label="{@review.preview}">
                                    # IF inuploadfolder.C_IS_PICTURE_FILE #
                                        <i class="far fa-eye" aria-hidden></i><img src="{PATH_TO_ROOT}/upload/{inuploadfolder.FILE_NAME}" />
                                    # ELSE #
                                        # IF inuploadfolder.C_IS_PDF_FILE #
                                            <i class="far fa-eye" aria-hidden></i><embed src="{PATH_TO_ROOT}/upload/{inuploadfolder.FILE_NAME}" />
                                        # ELSE #
                                            <i class="far fa-eye-slash" aria-hidden></i>
                                        # ENDIF #
                                    # ENDIF #
                                </span>
                            </td>
                        </tr>
                    # END inuploadfolder #
                </tbody>
            </table>
        </div>
    </article>
# ENDIF #

# IF C_FILES_IN_UPLOAD_TABLE #
    <article class="review-results">
        <header>
            <h2>{@review.counters.title.files.in.upload}</h2>
        </header>
        <div class="content">
            <table class="display review-table">
                <thead>
                    <tr>
                        <th>{@review.file.path}</th>
                        <th>{@review.file.upload.by}</th>
                        <th>{@review.file.timestamp}</th>
                        <th>{@review.file.size}</th>
                        <th aria-label="{@review.preview}" class="preview-col"><i class="far fa-eye" aria-hidden></i></th>
                    </tr>
                </thead>
                <tbody>
                    # START inuploadtable #
                        <tr>
                            <td class="align-left">
                                {inuploadtable.FILE_NAME}
                            </td>
                            <td>
                                {inuploadtable.FILE_UPLOAD_BY}
                            </td>
                            <td>
                                {inuploadtable.FILE_UPLOAD_DATE}
                            </td>
                            <td>
                                {inuploadtable.FILE_UPLOAD_SIZE}
                            </td>
                            <td class="align-right preview-col">
                                # IF inuploadtable.C_FILE #
                                    <span class="review-preview" aria-label="{@review.preview}">
                                        # IF inuploadtable.C_IS_PICTURE_FILE #
                                            <i class="far fa-eye" aria-hidden></i><img src="{PATH_TO_ROOT}/upload/{inuploadtable.FILE_NAME}" />
                                        # ELSE #
                                            # IF inuploadtable.C_IS_PDF_FILE #
                                                <i class="far fa-eye" aria-hidden></i><embed src="{PATH_TO_ROOT}/upload/{inuploadtable.FILE_NAME}" />
                                            # ELSE #
                                                <i class="far fa-eye-slash" aria-hidden></i>
                                            # ENDIF #
                                        # ENDIF #
                                    </span>
                                # ELSE #
                                    {@review.missing}
                                # ENDIF #
                            </td>
                        </tr>
                    # END inuploadtable #
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
                        <th aria-label="{@review.preview}"><i class="far fa-eye" aria-hidden></i></th>
                    </tr>
                </thead>
                <tbody>
                    # START incontenttable #
                        <tr>
                            <td class="align-left">
                                {incontenttable.FILE_PATH}
                            </td>
                            <td>
                                {incontenttable.FILE_MODULE_SOURCE}
                            </td>
                            <td>
                                # IF incontenttable.C_FILE_ITEM_TITLE #
                                    <a href="{incontenttable.FILE_ITEM_LINK}">{incontenttable.FILE_ITEM_TITLE}</a>
                                # ELSE #
                                    {@review.file.undetermined.link}
                                # ENDIF #
                            </td>
                            <td class="align-right">
                                # IF incontenttable.C_FILE #
                                    <span class="review-preview">
                                        # IF incontenttable.C_IS_PICTURE_FILE #
                                            <i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{incontenttable.FILE_PATH}" />
                                        # ELSE #
                                            # IF incontenttable.C_IS_PDF_FILE #
                                                <i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/upload/{incontenttable.FILE_PATH}" />
                                            # ELSE #
                                                <i class="fa fa-eye-slash"></i>
                                            # ENDIF #
                                        # ENDIF #
                                    </span>
                                # ELSE #
                                    {@review.missing}
                                # ENDIF #
                            </td>
                        </tr>
                    # END incontenttable #
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
                    # START usedbutmissing #
                        <tr>
                            <td>
                                {usedbutmissing.FILE_PATH}
                            </td>
                            <td>
                                {usedbutmissing.FILE_MODULE_SOURCE}
                            </td>
                            <td>
                                # IF usedbutmissing.C_FILE_ITEM_TITLE #
                                    <a href="{usedbutmissing.FILE_ITEM_LINK}">{usedbutmissing.FILE_ITEM_TITLE}</a>
                                # ELSE #
                                    {@review.file.undetermined.link}
                                # ENDIF #
                            </td>
                        </tr>
                    # END usedbutmissing #
                </tbody>
            </table>
        </div>
    </article>
# ENDIF #

# IF C_UNUSED_FILES_IN_TABLE #
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
                        <th aria-label="{@review.preview}"><i class="far fa-eye" aria-hidden></i></th>
                    </tr>
                </thead>
                <tbody>
                    # START unusedbutintable #
                        <tr>
                            <td class="flex-between">
                                {unusedbutintable.FILE_PATH}
                            </td>
                            <td>
                                {unusedbutintable.FILE_USER}
                            </td>
                            <td>
                                {unusedbutintable.FILE_UPLOAD_DATE}
                            </td>
                            <td>
                                {unusedbutintable.FILE_SIZE}
                            </td>
                            <td class="align-right">
                                # IF unusedbutintable.C_FILE #
                                    <span class="review-preview">
                                        # IF unusedbutintable.C_IS_PICTURE_FILE #
                                            <i class="fa fa-eye"></i><img src="{PATH_TO_ROOT}/upload/{unusedbutintable.FILE_PATH}" />
                                        # ELSE #
                                            # IF unusedbutintable.C_IS_PDF_FILE #
                                                <i class="fa fa-eye"></i><embed src="{PATH_TO_ROOT}/upload/{unusedbutintable.FILE_PATH}" />
                                            # ELSE #
                                                <i class="fa fa-eye-slash"></i>
                                            # ENDIF #
                                        # ENDIF #
                                    </span>
                                # ELSE #
                                    {@review.missing}
                                # ENDIF #
                            </td>
                        </tr>
                    # END unusedbutintable #
                </tbody>
            </table>
        </div>
    </article>
# ENDIF #

# IF C_ORPHAN_FILES #
    <article class="review-results">
        <header>
            <h2>{@review.counters.orphans.files}</h2>
        </header>
        <div class="content">
            <table class="display review-table">
                <thead>
                    <tr>
                        <th>{@review.file.path}</th>
                    </tr>
                </thead>
                <tbody>
                    # START orphans #
                        <tr>
                            # IF orphans.C_IS_PICTURE_FILE #
                                <td class="flex-between">
                                    {orphans.FILE_PATH}
                                    <span class="review-preview">
                                        <i class="fa fa-eye"></i>
                                        <img src="{PATH_TO_ROOT}/upload/{orphans.FILE_PATH}">
                                    </span>
                                </td>
                            # ELSE #
                                # IF orphans.C_IS_PDF_FILE #
                                    <td class="flex-between">
                                        {orphans.FILE_PATH}
                                        <span class="review-preview">
                                            <i class="fa fa-eye"></i>
                                            <embed src="{PATH_TO_ROOT}/upload/{orphans.FILE_PATH}">
                                        </span>
                                    </td>
                                # ELSE #
                                    <td class="flex-between">
                                        {orphans.FILE_PATH}
                                        <span class="review-preview">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </td>
                                # ENDIF #
                            # ENDIF #
                        </tr>
                    # END orphans #
                </tbody>
            </table>
        </div>
    </article>
# ENDIF #

# IF C_GALLERY #
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
                        # START galleryusedbutmissing #
                            <tr>
                                <td class="flex-between">{galleryusedbutmissing.FILE_PATH}</td>
                            </tr>
                        # END galleryusedbutmissing #
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
                        # START galleryunusedbutintable #
                            <tr>
                                <td class="flex-between">{galleryunusedbutintable.FILE_PATH}</td>
                            </tr>
                        # END galleryunusedbutintable #
                    </tbody>
                </table>
            </div>
        </article>
    # ENDIF #
# ENDIF #

<script>
    jQuery('.preloader-button').each(function() {
        jQuery(this).on('click', function() {
            jQuery('#admin-contents').fadeOut('slow');
            jQuery('#preloader-status').css({
                'visibility': 'visible',
                'opacity': 1,
                'height': '100%'
            });
        })
    });
</script>