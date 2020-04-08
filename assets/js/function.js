const handleNewPage = () => {
    const myurl = '/google/rechercheLivreaddict/' + this.props.search.trim() + '/' + this.state.page
    console.log(myurl)
    $.get({
        url: myurl

    })
        .done((data) => {
            this.setState({books: JSON.parse(data).books});
            this.setState({nbBook: JSON.parse(data).nbBook});
            //.nbBook = JSON.parse(data).nbBook
            console.log(this.state.books)
            $('.content').empty()
        })
}

export {handleNewPage}