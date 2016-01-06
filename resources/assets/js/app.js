$('#accordion .panel-collapse').on('shown.bs.collapse', function () {
    $(this).prev().find(".glyphicon").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
}).children().on('shown.bs.collapse', function (e) {
    e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
});

$('#accordion .panel-collapse').on('hidden.bs.collapse', function () {
    $(this).prev().find(".glyphicon").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
}).children().on('hidden.bs.collapse', function (e) {
    e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
});