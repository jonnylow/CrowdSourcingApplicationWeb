$(document).ready(function() {
    $('.fixed-table-toolbar .search').addClass('col-md-3 col-sm-5 col-xs-12');
    $('.pull-down').each(function() {
        $(this).css('margin-top', $(this).parent().height()-$(this).height());
    });
});

$('#accordion .panel-collapse').on('shown.bs.collapse', function () {
    $(this).prev().find(".icon-arrow").removeClass("fa-chevron-down").addClass("fa-chevron-up");
}).children().on('shown.bs.collapse', function (e) {
    e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
});

$('#accordion .panel-collapse').on('hidden.bs.collapse', function () {
    $(this).prev().find(".icon-arrow").removeClass("fa-chevron-up").addClass("fa-chevron-down");
}).children().on('hidden.bs.collapse', function (e) {
    e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$('.table').on('reset-view.bs.table', function() {
    $('[data-toggle="tooltip"]').tooltip();
});
