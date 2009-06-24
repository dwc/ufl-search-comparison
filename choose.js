$(document).ready(function() {
    $("form.choice").submit(function() {
        $("#loading").toggle();

        $.ajax({
            type: "POST",
            url: "index.php",
            data: $(this).serialize(),
            dataType: "html",
            success: function(xhr, status) {
                $("#loading").toggle();
            },
            error: function(xhr, status, message) {
                    //$("#loading").toggle();
                alert("Error saving selection: " + message);
            }
        });

        return false;
    });
});
