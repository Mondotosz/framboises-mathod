import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {
    // Highlights current dashboard nav
    let current = $("meta[dashboard-nav]").attr("dashboard-nav")
    if (current) {
        $(`[data-dashboard-nav='${current}']`).addClass("bg-pink-600 text-gray-50")
    }

})