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

    // Index members (creates a map with name:reference pairs)
    members = new Array();
    jQuery.each(jQuery("#zawiw-bp-memberlist .user"), function index (index, value) {
        name = jQuery(value).find(".name").text();
        members.push({name: name, object: value});
    });

    // Register change event on text input
    jQuery("#zawiw-bp-memberlist-search").on('change keydown paste input', null, "search", search );
});



function search (event) {
    query = jQuery(this).val();
    jQuery.each(members, function (index, member) {
        //console.log(member.name);
        if (member.name.toLowerCase().indexOf(query.toLowerCase()) > -1) {
            console.log("hit on " + member.name + " at " + member.name.indexOf(query));
            jQuery(member.object).show();
        } else {
            jQuery(member.object).hide();
        }
    });
}