import React from 'React';
import ElementPagination from './elementPagination.jsx'

export default class Pagination extends React.Component{
    constructor(props) {
        super(props)
        this.page =  props.page


    }




    create() {
        let pages =  []
        for (let nb=1; nb<=Math.trunc(this.props.pages / 10) + 1; nb++) {
            pages.push(<ElementPagination key={nb} page={nb} someMethod={this.props.someMethod} />)
        }
        //console.log(this.state.nbPage)
    return pages;
    }



    render() {
        console.log(this.props.page)
        return (<nav aria-label="Page navigation example" className="mt-4 d-flex justify-content-center" id="pagination">
            <ul className="pagination">
                <li className="page-item" data-position="previous"  onClick={() => this.props.someMethod(this.props.page - 1)} ><a className="page-link" href="#">Previous</a></li>
                { this.create() }
                <li className="page-item" data-position="next" onClick={() => this.props.someMethod(this.props.page + 1)}><a className="page-link" href="#">Next</a></li>
            </ul>
        </nav>)
    }
}

