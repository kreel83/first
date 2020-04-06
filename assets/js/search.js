const modal = () => {
    $('.tab-content').on('click','.card_livre',function() {
        let slug = '/display/'+$(this).attr('data-slug')
        slug = slug.split(' ').join('-')
        window.location = slug
    })
}


const livreParAuteur = () => {
    $('.card_auteur').click(function () {
        const link = $(this).attr('data-link')
        $.post({
            url: '/google/listeLivres',
            dataType: 'json',
            data: "link=" + link,
            success: (data) => {
                console.log(data.link)
                const d = data.link
                for (let i=0; i<d.length; i++) {
                    //console.log(data.link[i][0])
                    let data = ""
                    if (d[i][1].includes('livre')) {
                        data = `<li><a href="${ d[i][1].replace('/biblio','').replace('.html','') }">${d[i][0]}</a></li>`
                    } else {
                        data = `<h5>${d[i][0]}</h5>`
                    }
                    $('.body-livres').append(data)
                }
            }
        })
        $('.livreParAuteur').modal('toggle')
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
        console.log('click : ' + page + '---' + pageActuelle)

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

        const myurl = '/google/rechercheLivreaddict/' + titre.trim() + '/' + page
        console.log(myurl)
        $.get({
            url: myurl

        })
            .done((data) => {
                console.log(data)
                const books = JSON.parse(data);
                $('.content').empty()
                for (let i = 0; i < books.books.length; i++) {
                    const book = `<div class="card card_livre" data-slug="${books.books[i]['titre']}"
                         style="width: 200px;font-size: 0.8rem;margin: 10px;padding: 0; cursor:pointer;">
                        <div class="card-body d-flex justify-content-center">
                            <img src="${books.books[i]['photo']}" alt="" width="80" height="125">
                        </div>
                        <div class="card-footer">
                            ${books.books[i]['lien']}
                        </div>
                        <div class="card-footer">
                            <p>${books.books[i]['genre']}</p>
                            [<em>
                            ${books.books[i]['auteur']}

                        </em>]
                        </div>
                    </div> `
                    $('.content').append(book)
                }
                $('.pagination li').removeClass('active')
                $(`.pagination li:eq(${page})`).addClass('active')

            })
    })
}

export {modal, searchLivreAddict, navItems, livreParAuteur}