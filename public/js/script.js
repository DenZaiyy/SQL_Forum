$(document).ready(function () {
    $(".message").each(function () {
        if ($(this).text().length > 0) {
            $(this).slideDown(500, function () {
                $(this).delay(3000).slideUp(500);
            });
        }
    });

    $(".delete-btn").on("click", function () {
        return confirm("Etes-vous sûr de vouloir supprimer?");
    });

    $("#profil").on("click", function () {
        $("#dropdown").toggleClass("active");
    });
});

// $("#ajaxbtn").on("click", function() {
//     $.get(
//         "index.php?action=ajax", {
//             nb: $("#nbajax").text()
//         },
//         function(result) {
//             $("#nbajax").html(result)
//         }
//     )
// })
