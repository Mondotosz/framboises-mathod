import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {

    const recipeID = $("meta[recipe-id]").attr("recipe-id")

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
                $.post(`/recipes/edit/${recipeID}/add/ingredient`, [{ name: "handler", value: "ajax" }, ...form], (e) => {
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
                $.post(`/recipes/edit/${recipeID}/add/step`, [{ name: "handler", value: "ajax" }, ...form], (e) => {
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

    $("[data-recipe-update=step]").on("click", e => {
        let target = $(e.target)
        let stepID = target.closest("[step-id]").attr("step-id")
        let number = target.closest("[step-number]").attr("step-number")
        let instruction = target.closest("[step-instruction]").attr("step-instruction")
        $.get(`/view/assets/components/recipe/edit/updateStep.html`, (data) => {
            let modal = $(data)
            // update action
            modal.find("form").attr("action", `/recipes/edit/${recipeID}/update/step`)
            // load values
            modal.find("input[edit-input=number]").val(number)
            modal.find("input[edit-input=instruction]").val(instruction)
            // dismiss button
            modal.find("[modal-dismiss]").on("click", e => {
                e.preventDefault()
                modal.remove()
            })
            // submit
            modal.find("button[type=submit]").on("click", e => {
                e.preventDefault()
                let form = modal.find("form")
                $.post(form.attr("action"), [{ name: "handler", value: "ajax" }, { name: "stepID", value: stepID }, ...form.serializeArray()], e => {
                    let response = JSON.parse(e)
                    if (response.success) {
                        modal.remove()
                        location.reload()
                    } else {
                        console.log(response)
                    }
                })
            })
            $("body").append(modal)
        })
    })

    $("[data-recipe-update=ingredient]").on("click", e => {
        let target = $(e.target)
        let ingredientID = target.closest("[ingredient-id]").attr("ingredient-id")
        let amount = target.closest("[ingredient-amount]").attr("ingredient-amount")
        let name = target.closest("[ingredient-name]").attr("ingredient-name")
        $.get(`/view/assets/components/recipe/edit/updateIngredient.html`, (data) => {
            let modal = $(data)
            // update action
            modal.find("form").attr("action", `/recipes/edit/${recipeID}/update/ingredient`)
            // load values
            modal.find("input[edit-input=amount]").val(amount)
            modal.find("input[edit-input=name]").val(name)
            // dismiss button
            modal.find("[modal-dismiss]").on("click", e => {
                e.preventDefault()
                modal.remove()
            })
            // submit
            modal.find("button[type=submit]").on("click", e => {
                e.preventDefault()
                let form = modal.find("form")
                $.post(form.attr("action"), [{ name: "handler", value: "ajax" }, { name: "ingredientID", value: ingredientID }, ...form.serializeArray()], e => {
                    let response = JSON.parse(e)
                    if (response.success) {
                        modal.remove()
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
            try {
                let response = JSON.parse(e)
                if (response.success) {
                    $(`[ingredient-id=${response.id}]`).remove()
                } else {
                    console.log(response)
                }
            } catch (err) {
                console.log(err)
            }
        })
    })

    $("[data-recipe-delete=step]").on("click", e => {
        //TODO add confirmation
        let target = $(e.target)
        let id = target.closest("[step-id]").attr("step-id")

        $.post(`/recipes/edit/${$("meta[recipe-id]").attr("recipe-id")}/delete/step`, [{ name: "handler", value: "ajax" }, { name: "confirmation", value: true }, { name: "stepID", value: id }], (e) => {
            try {
                let response = JSON.parse(e)
                if (response.success) {
                    $(`[step-id=${response.id}]`).remove()
                } else {
                    console.log(response)
                }
            } catch (err) {
                console.log(err)
            }
        })
    })
})
