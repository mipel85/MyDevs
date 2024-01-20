<script src="{PATH_TO_ROOT}/templates/club/js/retrieve.caps# IF C_CSS_CACHE_ENABLED #.min# ENDIF #.js"></script>
<script src="{PATH_TO_ROOT}/templates/club/js/scroll.circle# IF C_CSS_CACHE_ENABLED #.min# ENDIF #.js"></script>

<script>
    jQuery(document).ready(function() {
        retrieveCaps(jQuery('#site-name'));
        jQuery(window).on("load scroll", function() {  PxScrollCircle();  });
        jQuery('#scroll-circle .back-to-top').on('click', function(){
            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    });
</script>

<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Goudy+Bookletter+1911&display=swap" rel="stylesheet">