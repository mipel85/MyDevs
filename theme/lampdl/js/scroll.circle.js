function HeightPercent() {
    var contentHeight = jQuery('body').outerHeight();
    var winHeight = jQuery(window).outerHeight();
    var position = jQuery(window).scrollTop();
    var lastScreenPos = contentHeight - winHeight;

    if (lastScreenPos != 0)
        var heightRatio = position / lastScreenPos;
    else
        var heightRatio = position / (contentHeight + 100);

    if (heightRatio > 1)
        heightRatio = 1;

    var heightPercentage = Math.round(heightRatio * 100);

    return heightPercentage;
}

function PxScrollCircle() {
    var loop = 100 / HeightPercent();
    var increment = Math.round(360 / loop);
    var degre = (90 + increment);
    var target = jQuery("#scroll-circle .progression");

    if (increment < 180)
        target.css({
            'background-image':'linear-gradient(90deg, var(--bgc-alt) 50%, transparent 50%), linear-gradient(' + degre + 'deg, var(--bgc-main) 50%, var(--bgc-alt) 50%)'
        });
    else
        target.css({
            'background-image':'linear-gradient(' + degre + 'deg, var(--bgc-main) 50%, transparent 50%), linear-gradient(270deg, var(--bgc-main) 50%, var(--bgc-alt) 50%)'
        });

    jQuery("#scroll-circle .percentage").html(HeightPercent() + "%");
}
