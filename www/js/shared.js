$(document).ready(function () {
    /* Delete user from table functions */
    /*----------------------------------*/
    $(document).on('click', '*[data-modal-anchor]', function () {
        $(".modal-window").removeClass("show");
        $(".modal-window[data-modal='" + $(this).data("modal-anchor") + "']").addClass("show");
    });

    /* Hide modal widow */
    /*---------------------------------*/
    $(document).on('click', '.hide-modal', function () {
        $(".modal-window").removeClass("show");
        var url = window.location.search;
        var lastParameter = url.indexOf("&edit") !== -1 ? "&edit" : "&add";
        var newUrl = url.substring(0, url.indexOf(lastParameter));
        if (newUrl !== "")
            window.location = newUrl; //Remove parameters from url (editUser)
        //TODO This is really bad algorithm to remove last get parameter
    });

    //hide on click anywhere but on form in modal window (if you click on white field)
    $(document).on('click', '.layer-hide', function () {
        $(this).parent().removeClass("show");
        var url = window.location.search;
        var lastParameter = url.indexOf("&edit") !== -1 ? "&edit" : "&add";
        var newUrl = url.substring(0, url.indexOf(lastParameter));
        if (newUrl !== "")
            window.location = newUrl; //Remove parameters from url (editUser)
        //TODO This is really bad algorithm to remove last get parameter
    });

    /* Toggle mobile nav icon & nav menu classes */
    $(".nav-icon").click(function () {
        $(this).parent().toggleClass("active");
        $(this).toggleClass("active");
        $(".nav-col").toggleClass("active");
    });
});


function searchTable(inputTarget, tableTarget, colId) {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(inputTarget);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableTarget);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[colId];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}