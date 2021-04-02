import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {
    // Highlights current nav
    let current = $("meta[nav]").attr("nav")
    if (current) {
        $("[data-nav]").addClass("bg-pink-600 text-gray-50")
    }

    // add toggler functionality
    $("[data-toggle='nav-collapse']").on("click", () => {
        let navCollapse = $("[data-nav-collapse]")

        if (navCollapse) {
            if (navCollapse.hasClass("hidden")) {
                navCollapse.removeClass("hidden").addClass("flex")
            } else {
                navCollapse.removeClass("flex").addClass("hidden")
            }
        }

    })
})