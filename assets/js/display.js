const goToSelectedDiv = () => {
    $('.action div').click(function () {
        const book = $('#id').val()
        const id = $(this).attr('id')
        if (id == 'wl') {window.location='/add/to/'+book+'/'+id}
        if (id == 'la') {window.location='/add/to/'+book+'/'+id}
        if (id == 'ar') {

            $('#ar_modal').modal('show')
        }
        if (id == 'll') {window.location='/add/to/'+book+'/'+id}


    })
}

const setMdoal= () => {

    $('.card-livre-mapage').click(function () {

        const statut = $(this).attr('data-statut')
        $('#wl_id').val($(this).attr('data-id'))
        if (statut == 'wl') { $('#wl_modal').modal("show") }
    })
}

export {goToSelectedDiv, setMdoal}