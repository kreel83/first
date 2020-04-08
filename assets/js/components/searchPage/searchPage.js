import React from 'React';
import Book from './bookCard/book';
import Author from './authorCard/author'
import Pagination from './bookCard/pagination';


export default class SearchPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            books: [],
            authors: [],
            nbBook: 0
        }
        this.search = props.search
        this.page = props.page
    }


    handleNewPage = (page) => {
        console.log(page)
        if (page == 8) {
            page = 7;
        }
        if (page == 0) {
            page = 1;
        }
        this.page = page
        $('.page-item').removeClass('active')
        $(`.page-item[data-position="${page}"]`).addClass('active')
        const myurl = '/google/rechercheLivreaddict/' + this.props.search.trim() + '/' + this.page
        console.log(myurl)
        $.get({
            url: myurl

        })
            .done((data) => {
                this.setState({books: JSON.parse(data).books});
                this.setState({authors: JSON.parse(data).authors});

                this.setState({nbBook: JSON.parse(data).nbBook});
                //let store = createStore(JSON.parse(data).books);
                //.nbBook = JSON.parse(data).nbBook
                console.log(this.state.authors)
                $('.content').empty()
            })
    }

    showLivre =() => {
        $('.nav-pills li').removeClass('active')
        $('#livre_tab').addClass('active')
        $("div[data-id='auteur_tab']").removeClass('show active')
        $("div[data-id='livre_tab']").addClass('show active')
    }

    showAuteur =() => {
        $('.nav-pills li').removeClass('active')
        $('#auteur_tab').addClass('active')
        $("div[data-id='livre_tab']").removeClass('show active')
        $("div[data-id='auteur_tab']").addClass('show active')
    }

    componentDidMount() {

        this.handleNewPage(this.page)
    }

    render() {
        console.log(this.page)
        const liste = this.state.books.map((el, index) => <Book key={index} details={el}/>)
        const listeAuteurs = this.state.authors.map((el, index) => <Author key={index} details={el}/>)
        return (
            /**/

            <div>
                <ul className="nav nav-pills">

                    <li className="active" id="livre_tab" onClick={this.showLivre}>Livres</li>
                    <li id="auteur_tab" onClick={this.showAuteur}>Auteurs</li>

                </ul>

                <div className="tab-content">

                    <div data-id="livre_tab" className="tab-pane fade show active" >


                        <Pagination pages={this.state.nbBook} search={this.props.search} page={this.page}
                                    someMethod={this.handleNewPage}/>
                        <div className="tab-pane fade show active">
                            {liste}
                        </div>


                    </div>
                    <div data-id="auteur_tab" className="tab-pane fade d-flex justify-content-center flex-wrap">

                        { listeAuteurs }
                    </div>

                </div>

            </div>


        )

    }
}