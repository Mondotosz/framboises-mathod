import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {
    // Highlights current nav
    let current = $("meta[nav]").attr("nav")
    if (current) {
        $(`[data-nav='${current}']`).addClass("bg-pink-600 text-gray-50")
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

    // User dropdown
    // TODO : Export to main
    $("[data-dropdown]").on("click", (e) => {
        let target = $(e.target).closest("[data-dropdown]").attr("data-dropdown")
        if (target) {
            $(`[data-dropdown-target="${target}"]`).toggleClass("hidden")
        }
    })

    $('body').on("click", (e) => {
        if (!$(e.target).closest("[data-dropdown-target]").length && $("[data-dropdown-target]").not(".hidden").length && !$(e.target).closest("[data-dropdown]").length) {
            $("[data-dropdown-target]").not(".hidden").addClass("hidden")
        }
    })

})