$(document).ready(function () {

    $(".card").click(function () {
        $(".role-var").val($(this).data("role"));
        $(".role-title").text($(this).data("login-type"));
        $(".role-choose").addClass("hide");
        $(".form-show").addClass("show");
        $(".img-avatar").attr("src", $(this).find(".avatar").attr("src"));
    });

    $(".btn-back").click(function () {
        $(".role-choose").removeClass("hide");
        $(".form-show").removeClass("show");
    });
});
