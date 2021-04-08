import "/node_modules/jquery/dist/jquery.min.js"

/**
 * To use this utility, you need to use attributes
 * <div data-collapse-control="exemple">
 *      <div data-collapse-indicator="on">on indicator</div>
 *      <div data-collapse-indicator="off">off indicator</div>
 * </div>
 * 
 * <div data-collapse="exemple"> my collapsible element</div>
 */


jQuery(() => {

    // Select all collapse controls
    $("[data-collapse-control]").on("click", (event) => {
        // Get all the moving parts
        let collapse = $(event.target).closest("[data-collapse-control]")
        let target = $(`[data-collapse=${collapse.attr("data-collapse-control")}]`)
        let indicators = collapse.find("[data-collapse-indicator]")
        let indicatorOn = indicators.filter("[data-collapse-indicator=on]")
        let indicatorOff = indicators.filter("[data-collapse-indicator=off]")

        // Toggle collapse
        if (target.hasClass("hidden")) {
            target.removeClass("hidden")
            indicatorOn.addClass("hidden")
            indicatorOff.removeClass("hidden")
        } else {
            target.addClass("hidden")
            indicatorOff.addClass("hidden")
            indicatorOn.removeClass("hidden")
        }
    })
})