$(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = "?page=TeacherPage&view=" + $(this).data("subject-id");
    });
});