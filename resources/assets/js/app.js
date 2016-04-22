$(document).ready(function() {
    // Lengthen the search bar
    $('.fixed-table-toolbar .search').addClass('col-md-3 col-sm-5 col-xs-12');

    // Quick-hack to align-bottom an element by giving it the .pull-down class
    $('.pull-down').each(function() {
        $(this).css('margin-top', $(this).parent().height()-$(this).height());
    });

    // Change the arrow-down icon to arrow-up when a panel is shown
    $('#accordion .panel-collapse').on('shown.bs.collapse', function () {
        $(this).prev().find(".icon-arrow").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }).children().on('shown.bs.collapse', function (e) {
        e.stopPropagation(); // Stop the inner collapsible panel from toggling the icon
    });

    // Change the arrow-up icon to arrow-down when a panel is collapsed
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
});
