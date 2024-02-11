<div class="sub-section">
    <div class="content-container">
        <div class="content">
            <h2>{@financial.legend}</h2>
            <div class="cell-flex cell-columns-2">
                <div class="cell">
                    {@H|financial.pending.legend.user}
                </div>
                # IF C_MONITORING #
                    <div class="cell">
                        {@H|financial.pending.legend.monitoring}
                    </div>
                # ENDIF #
            </div>
        </div>
    </div>
</div>

# IF C_MONITORING #
    <script>
        jQuery('.monitoring-input').each(function() {
            let amount = jQuery(this).val(),
                target = jQuery(this).siblings('.payment-button'),
                href = target.attr('href');
            target.attr('href', href + amount);
            jQuery(this).on('change',function() {
                amount = jQuery(this).val();
                parts = href.split('/');
                parts[parts.length - 1] = amount;
                let new_href = parts.join('/');
                target.attr('href', new_href);
            });
        });
    </script>
# ENDIF #