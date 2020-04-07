import React from 'React';
import Book from './bookCard/book';
import Pagination from './bookCard/pagination';

export default class SearchPage extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            books: [],
            page: 1,
            nbBook : 0}
        this.search = props.search
    }


    componentDidMount() {
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

    render() {
        console.log(this.state.nbBook)
        const liste = this.state.books.map((el, index) => <Book key={index} details={el}  />)
        return (
        <div>
            <Pagination pages={this.state.nbBook} search={this.props.search}/>
        <div className="tab-pane fade show active">
            { liste }
        </div>
        </div>)
    }
}