import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {

    $("#btnIngredientsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/create/ingredient.html", data => {
            let table = $("[data-recipe-create=ingredients]")
            let id: number = parseInt(table.attr("data-current-increment"))
            // increment
            table.attr("data-current-increment", id++)
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
            table.attr("data-current-increment", id++)
            // get row and initialize events
            let row = $(data.replaceAll(/{{id}}/g, id))
            row.find("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
            table.append(row)
        })
    })

    $("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
})

function deleteRow(element: HTMLElement) {
    $(element).closest("tr").remove()
}