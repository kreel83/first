const modal = () => {
    $('.card').click(() => {
        $('.modal').modal('toggle')
    })
}


const navItems = () => {
    $('.nav-pills li').click(function () {
        const id = $(this).attr('id')
        $('.tab-content div').removeClass('active show')
        $(`.tab-content div[data-id="${id}"]`).addClass('active show')
    })
}


const searchLivreAddict = () => {
    $('#pagination li').click(function () {
        let page = $(this).attr('data-position')
        const titre = $('#titre').val()
        const nbpage = $('.pagination li').length - 2
        const pageActuelle = parseInt($('.pagination li.active').attr('data-position'))
        console.log(pageActuelle)
        if (page == 1) {
            $('.pagination').find("li:first").attr('hidden', true)
        } else {
            $('.pagination').find("li:first").attr('hidden', false)
        }
        if (page == nbpage) {
            $('.pagination').find("li:last").attr('hidden', true)
        } else {
            $('.pagination').find("li:last").attr('hidden', false)
        }
        if (page == 'next') {
            page = pageActuelle + 1
            if (page == nbpage) {
                $('.pagination').find("li:last").attr('hidden', true)
            }

        }
        if (page == 'previous') {
            page = pageActuelle - 1
            if (page == 1) {
                $('.pagination').find("li:first").attr('hidden', true)
            }
        }


        $.get({
            url: '/google/rechercheLivreaddict/' + titre + '/' + page
        })
            .done((data) => {
                    const books = JSON.parse(data);

                    $('.content').empty()





                    for (let i = 0; i < books.length; i++) {
                        const book = `<div class="card"
                         style="width: 200px;font-size: 0.8rem;margin: 10px;padding: 0; cursor:pointer;">
                        <div class="card-body d-flex justify-content-center">
                            <img src="${books[i]['photo']}" alt="" width="80" height="125">
                        </div>
                        <div class="card-footer">
                            ${books[i]['lien']}
                        </div>
                        <div class="card-footer">
                            <p>${books[i]['genre']}</p>
                            [<em>
                            ${books[i]['auteur']}

                        </em>]
                        </div>
                    </div> `
                        $('.content').append(book)
                        $('.pagination li').removeClass('active')
                        $(`.pagination li:eq(${page})`).addClass('active')


                    }


                }
            )
    })
}

export {modal, searchLivreAddict, navItems}