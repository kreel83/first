const modal = () => {
    $('.tab-content').on('click','.card_livre',function() {
        let slug = '/livre/'+$(this).attr('data-slug')
        slug = slug.split(' ').join('-')
        window.location = slug
    })
}


const livreParAuteur = () => {
    $('.card_auteur').click(function () {
        const link = $(this).attr('data-link')
        console.log(link)
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
        console.log('coucou')
        $('#auteurs_modal').modal('toggle')
    })
}


const navItems = () => {
    $('.nav-pills li').click(function () {
        const id = $(this).attr('id')
        $('.nav-pills li').removeClass('active')
        $(this).addClass('active')
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

            if (page == "next") {

                if (pageActuelle == nbpage)
                {page = pageActuelle} else { page = pageActuelle + 1}

            }
        if (page == "previous") {

            if (pageActuelle == 1)
            {page = pageActuelle} else { page = pageActuelle - 1}

        }



        const myurl = '/google/rechercheLivreaddict/' + titre.trim() + '/' + page
        console.log(myurl)
        $.get({
            url: myurl

        })
            .done((data) => {
                console.log(data)
                const books = JSON.parse(data);
                $('.listeLivre').empty()
                for (let i = 0; i < books.books.length; i++) {
                    const book = `<div class="card card_livre" data-slug="${books.books[i]['titre']}"
                         style="width: 200px;font-size: 0.8rem;margin: 10px;padding: 0; cursor:pointer;">
                        <div class="card-body d-flex justify-content-center">
                            <img src="${books.books[i]['imageurl']}" alt="" width="80" height="125">
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
                    $('.listeLivre').append(book)
                }
                $('.pagination li').removeClass('active')
                $(`.pagination li:eq(${page})`).addClass('active')

            })
    })
}

export {modal, searchLivreAddict, navItems, livreParAuteur}