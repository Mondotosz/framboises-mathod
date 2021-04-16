import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {
    $("[calendar-item]").on("click", event => {
        let target = $(event.target).closest("[calendar-item]")
        let start = target.attr("data-opening-start")
        let end = target.attr("data-opening-end")
        let description = target.attr("data-opening-description")
        let places = target.attr("data-opening-places")

        let wrapper = $("<div>", {
            class: "fixed inset-0 z-10 flex flex-col justify-center overflow-y-auto bg-black bg-opacity-30",
            modal: ""
        })

        let modal = $("<div>", { class: "modal lg:max-w-7xl mx-auto bg-red-200 rounded-md" })

        // Header
        let header = $("<div>", { class: "modal-header flex flex-row justify-between px-3 py-2 space-x-4" })
        let title = $("<div>",
            {
                class: "font-medium",
                html:`${start}  -  ${end}`
            })
        header.append(title)
        let dismiss = $(
            `<svg modal-dismiss class="h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>`
        ).on("click", e => { $(e.target).closest("[modal]").remove() })
        header.append(dismiss)
        modal.append(header)

        // Body
        let body = $("<div>",
            {
                class: "modal-body px-3 py-2",
                html: `${description}`
            })
        modal.append(body)

        // Mount modal
        wrapper.append(modal)
        $("body").append(wrapper)
    })
})