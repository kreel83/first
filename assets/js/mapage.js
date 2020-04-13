const selectLA = () => {
    $(".card-livre-mapage[data-statut='la']").click(function () {
        const book = $(this).attr('data-id')
        window.location='/reading/'+book
    })
}

export {selectLA}