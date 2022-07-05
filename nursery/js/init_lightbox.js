$(function() {
    $('a[rel*=lightbox]').lightBox({
        imageLoading   : "/js/lightbox/images/lightbox-ico-loading.gif"
        ,imageBtnClose : "/js/lightbox/images/lightbox-btn-close.gif"
        ,imageBtnPrev  : "/js/lightbox/images/lightbox-btn-prev.gif"
        ,imageBtnNext  : "/js/lightbox/images/lightbox-btn-next.gif"
        ,imageBlank    : "/js/lightbox/images/lightbox-blank.gif"
    });

/*    $("#screenshots a").lightBox({
        imageLoading   : "/nursery/js/lightbox/images/lightbox-ico-loading.gif"
        ,imageBtnClose : "/nursery/js/lightbox/images/lightbox-btn-close.gif"
        ,imageBtnPrev  : "/nursery/js/lightbox/images/lightbox-btn-prev.gif"
        ,imageBtnNext  : "/nursery/js/lightbox/images/lightbox-btn-next.gif"
        ,imageBlank    : "/nursery/js/lightbox/images/lightbox-blank.gif"
    });*/
});
