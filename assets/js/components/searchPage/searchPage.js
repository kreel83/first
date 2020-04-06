import React from 'React';
import Book from './bookCard/book';
import Pagination from './bookCard/pagination';

export default class SearchPage extends React.Component{
    constructor(props) {
        super(props);
        this.books = props.books
        this.pagination = props.pagination
    }



    render() {
        console.log(this.props.books)
        const liste = this.props.books.map((el, index) => <Book key={index} details={el}  />)
        return (
        <div>
            <Pagination pages={this.props.pagination}/>
        <div className="tab-pane fade show active">
            { liste }
        </div>
        </div>)
    }
}