const selectCategory = () => {
    $('#selectCategory').change(function() {
        const r = $(this).find(':selected').val();
        $.ajax({
            url: "/ajaxCall",
            method:"post",
            data: {id: r}
        })
            .done(function(data){
                $('.content').empty()
                let content = $('.content')
                $('h1').html(`${data.length} books`)
                for (let i = 1; i<data.length; i++) {
                    content.append(`<div class='row'><div class='col-3'><h6>${data[i].titre}</h6><p>${data[i].author}</p></div><div class='col'><p>${data[i].description}</p></div></div><hr>`)
                }
                    console.log(data)
            })
    })
}

export {selectCategory}