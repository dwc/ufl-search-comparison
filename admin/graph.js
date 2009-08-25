$(document).ready(function() {
    var draw_graph = function() {
        var img_id = "graph";
        var base_url = "http://chart.apis.google.com/chart";
        var width = 600;
        var height = 400;

        var params = {
            cht: "bvg",
            chs: width + "x" + height,
            chbh: "r,0.25,1.50",
            chco: "ff0000,00ff00,0000ff",
            chxt: "x"
        };

        // Collect the data
        var axis_labels = [];
        var data = [];
        var max_wins = 0;

        var checked_boxes = $('table#results input[type="checkbox"]:checked');
        $(checked_boxes).each(function() {
            var query = $(this).attr("value");
            axis_labels.push(query);

            var i = 0;
            $(this).parent().siblings(".result").each(function() {
                var num_wins = parseInt($(this).text());

                if (! data[i]) data[i] = [];
                data[i++].push(num_wins);

                if (num_wins > max_wins) {
                    max_wins = num_wins;
                }
            });
        });

        // Add the axis labels to the parameter list
        params["chxl"] = "0:";
        for (var i = 0; i < axis_labels.length; i++) {
            params["chxl"] += "|" + axis_labels[i];
        }

        // Add the data to the parameter list
        var serialized_data = [];
        for (var i = 0; i < data.length; i++) {
            serialized_data.push(data[i].join(","));
        }

        params["chd"] = "t:" + serialized_data.join("|");

        // Set the scale
        params["chds"] = "0," + max_wins;

        // Add the legend
        var legend_labels = [];
        $("table#results th.choice").each(function() {
            legend_labels.push($(this).text());
        });

        params["chdl"] = $.makeArray(legend_labels).join("|");

        // Load the graph
        $("img#" + img_id).remove();
        $("table#results").after('<img src="' + base_url + '?' + $.param(params) + '" width="' + width + '" height="' + height + '" alt="Graph of selected results" id="' + img_id + '" />');
    }

    // Load a new graph when a checkbox is clicked to add or remove a query
    $('table#results input[type="checkbox"]').click(function() {
        draw_graph();
    });

    // By default, the totals line is checked
    draw_graph();
});
