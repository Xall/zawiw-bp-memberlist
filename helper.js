// decodes base64 encodes emails

function decode (index, codeHTML) {

    // Explicit jQuery cast
    codeHTML = jQuery(codeHTML);
    var code = codeHTML.html();

    codeHTML.html(atob(code));
    // decode
    codeHTML.attr("href", "mailto:"+atob(code));
}
jQuery( document ).ready(function() {

    // For each loop over all emails
    jQuery.each(jQuery("#zawiw-bp-memberlist .email a"), decode);

});