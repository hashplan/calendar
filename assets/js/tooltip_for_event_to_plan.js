$(document).ready(function () {
    $('.added').popover({
        trigger: "click",
        placement: "top",
        title: "Cool",
        content: "Added to your #plan",
    });
    $('.deleted').popover({
        trigger: "click",
        placement: "top",
        title: "Boo",
        content: "Deleted from your #plan",
    });
});
