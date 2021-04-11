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
            modal.find("button[type=submit]").on("click", (e) => {
                e.preventDefault()
                // get form
                let form = $(e.target).closest("form").serializeArray()

                // send request
                $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/add/ingredient`,[{name:"handler",value:"ajax"},...form],(e)=>{
                    let response = JSON.parse(e)
                    if (response.success) {
                        $("[modal]").remove()
                        location.reload()
                    } else {
                        console.log(response)
                    }
                })

            })
            $("body").append(modal)
        })
    })

    $("#btnStepsAdd").on("click", (event) => {
        $.get("/view/assets/components/recipe/edit/step.html", data => {
            let modal = $(data.replaceAll(/{{id}}/g, $("meta[recipe-id]").attr("recipe-id")))
            // dismiss modal on click
            modal.find("[modal-dismiss]").on("click", e => {
                $(e.target).closest("[modal]").remove()
            })
            // submit logic
            modal.find("button[type=submit]").on("click", (e) => {
                e.preventDefault()
                // get form
                let form = $(e.target).closest("form").serializeArray()

                // send request
                $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/add/step`, [{ name: "handler", value: "ajax" }, ...form], (e) => {
                    let response = JSON.parse(e)
                    if (response.success) {
                        $("[modal]").remove()
                        location.reload()
                    } else {
                        console.log(response)
                    }
                })

            })
            $("body").append(modal)
        })

    })

    $("[data-recipe-delete=row]").on("click", e => { deleteRow(e.target) })
})

function deleteRow(element: HTMLElement) {
    $(element).closest("tr").remove()
}