$(document).ready(function () {

    $(".list a").click(function() {
        $( this ).parent().find(".selected").removeClass( "selected" );
        $( this ).addClass("selected")
    });

    $(".list-item-users").click(function () {
        $( ".container").find(".show").removeClass( "show" ).addClass("hide");
        $(".users").removeClass("hide").addClass("show");
    });

    $(".list-item-create").click(function () {
        $( ".container").find(".show").removeClass( "show" ).addClass("hide");
        $(".create-user").removeClass("hide").addClass("show");
    });

    $(".list-item-import").click(function () {
        $( ".container").find(".show").removeClass( "show" ).addClass("hide");
        $(".import-users").removeClass("hide").addClass("show");
    });

});