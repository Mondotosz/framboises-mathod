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
                $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/add/ingredient`, [{ name: "handler", value: "ajax" }, ...form], (e) => {
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
            //TODO replace with server side data
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

    $("[data-recipe-delete=ingredient]").on("click", e => {
        //TODO add confirmation
        let target = $(e.target)
        let id = target.closest("[ingredient-id]").attr("ingredient-id")

        $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/delete/ingredient`, [{ name: "handler", value: "ajax" }, { name: "confirmation", value: true }, { name: "ingredientID", value: id }], (e) => {
            try{
                let response = JSON.parse(e)
                if (response.success) {
                    $(`[ingredient-id=${response.id}]`).remove()
                } else {
                    console.log(response)
                }
            } catch(err){
                console.log(err)
            }
        })
    })

    $("[data-recipe-delete=step]").on("click", e => {
        //TODO add confirmation
        let target = $(e.target)
        let id = target.closest("[step-id]").attr("step-id")

        $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/delete/step`, [{ name: "handler", value: "ajax" }, { name: "confirmation", value: true }, { name: "stepID", value: id }], (e) => {
            try{
                let response = JSON.parse(e)
                if (response.success) {
                    $(`[step-id=${response.id}]`).remove()
                } else {
                    console.log(response)
                }
            } catch(err){
                console.log(err)
            }
        })
    })
})
