$(document).ready(function() {
    $("form.choice").submit(function() {
        var form = $(this);

        // Disable choice buttons
        $('form.choice input[type="submit"]').attr("disabled", "disabled");

        // Hide any outstanding images, then show this form's loading image
        $("img.loading, img.success").hide();
        form.find("img.loading").toggle();

        $.ajax({
            type: "POST",
            url: "index.php",
            data: form.serialize(),
            dataType: "html",
            success: function(xhr, status) {
                form.find("img.loading, img.success").toggle();
            },
            error: function(xhr, status, message) {
                form.find("img.loading").toggle();
                alert("Error saving selection: " + message);
            }
        });

        return false;
    });
});
