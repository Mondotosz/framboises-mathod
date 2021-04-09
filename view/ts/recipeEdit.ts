import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {

    $("a[data-collapse-control]").on("click", e => e.preventDefault())

    $("#btnIngredientsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/create/ingredient.html", data => {
            let table = $("[data-recipe-create=ingredients]")
            let id: number = parseInt(table.attr("data-current-increment"))
            // increment
            table.attr("data-current-increment", id + 1)
            // get row and initialize events
            let row = $(data.replaceAll(/{{id}}/g, id))
            row.find("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
            table.append(row)
        })
    })

    $("#btnStepsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/create/step.html", data => {
            let table = $("[data-recipe-create=steps]")
            let id: number = parseInt(table.attr("data-current-increment"))
            // increment
            table.attr("data-current-increment", id + 1)
            // get row and initialize events
            let row = $(data.replaceAll(/{{id}}/g, id))
            // pre-fill number
            row.find(`[name$=${$.escapeSelector("[number]")}]`).val(id + 1)
            row.find("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
            table.append(row)
        })
    })

    $("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
})

function deleteRow(element: HTMLElement) {
    $(element).closest("tr").remove()
}