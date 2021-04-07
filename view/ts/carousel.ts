import "/node_modules/jquery/dist/jquery.min.js"

jQuery(() => {
    let carousels = $("[data-carousel]")

    // initialize each carousel
    carousels.each((_e, carousel) => {
        $(carousel).find("[data-carousel-next]").on("click", next)
        $(carousel).find("[data-carousel-previous]").on("click", previous)
    })
})

function next(event: Event) {
    let carousel = $(event.target).closest("[data-carousel]")
    let items = carousel.find("[data-carousel-item]")
    let current = items.index(items.not(".hidden"))
    let nextItem = current + 1
    // check if end of carousel
    if (items.length - 1 < nextItem) {
        nextItem = 0
    }

    items.eq(current).addClass("hidden")
    items.eq(nextItem).removeClass("hidden")

}

function previous(event: Event) {
    let carousel = $(event.target).closest("[data-carousel]")
    let items = carousel.find("[data-carousel-item]")
    let current = items.index(items.not(".hidden"))
    let previousItem = current - 1
    // check if start of carousel
    if (previousItem < 0) {
        previousItem = items.length - 1
    }

    items.eq(current).addClass("hidden")
    items.eq(previousItem).removeClass("hidden")

}