import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {

    $("a[data-collapse-control]").on("click", e => e.preventDefault())

    $("#btnIngredientsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/edit/ingredient.html", data => {
            let modal = $(data.replaceAll(/{{id}}/g, $("meta[recipe-id]").attr("recipe-id")))
            // dismiss modal on click
            modal.find("[modal-dismiss]").on("click", e => {
                $(e.target).closest("[modal]").remove()
            })
            // submit logic
            modal.find("[ajax-submit]").on("click", (e) => {
                // get form
                let data = new FormData();
                let form = $(e.target).closest("form").serializeArray()

                form.forEach((e) => {
                    data.set(e.name, e.value)
                })

                data.set("handler","ajax")

                // send request
                $.ajax({
                    type: 'POST',
                    url: `${window.location.origin}/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/add/ingredient`,
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: e => {
                        let response = JSON.parse(e)

                        if(response.response == "success"){
                            $("[modal]").remove()
                            location.reload()
                        } else {
                            console.log(response)
                        }
                    }
                })
            })
            $("body").append(modal)
        })
    })

    $("#btnStepsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/edit/step.html", data => {
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