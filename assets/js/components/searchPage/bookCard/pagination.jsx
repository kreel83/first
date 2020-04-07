import React from 'React';
import ElementPagination from './elementPagination.jsx'

export default class Pagination extends React.Component{
    constructor(props) {
        super(props)
        this.pages = props.pages
        this.search = props.search
        console.log(this.pages)
    }



    create() {
        let pages =  []
        for (let nb=1; nb<=Math.trunc(this.props.pages / 10) + 1; nb++) {
            pages.push(<ElementPagination key={nb} page={nb} search={this.props.search} />)
        }
        //console.log(this.state.nbPage)
    return pages;
    }
    render() {
        return (<nav aria-label="Page navigation example" className="mt-4 d-flex justify-content-center" id="pagination">
            <ul className="pagination">
                <li className="page-item" data-position="previous"><a className="page-link" href="#">Previous</a></li>
                { this.create() }
                <li className="page-item" data-position="next"><a className="page-link" href="#">Next</a></li>
            </ul>
        </nav>)
    }
}