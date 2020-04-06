import React from 'React';

export default class Pagination extends React.Component{
    constructor(props) {
        super(props)
        this.pages = props.pages
        this.state = {
            nbPage : 0
        }
    }

    componentDidMount() {
        this.setState({nbPage : Math.trunc(this.props.pages / 10) + 1});
    }

    handleClick = () => {
        console.log('click')
    }


    create() {
        let pages =  `<li class="page-item" data-position="previous"><a class="page-link" href="#">Previous</a></li>`
        for (let nb=1; nb<=this.state.nbPage; nb++) {
            pages += `
           <li class="page-item" data-position="${nb}"><a class="page-link" href="#" onclick="this.handleClick()" >${nb}</a></li>
            `
        }
        return pages+ `<li class="page-item" data-position="next"><a class="page-link" href="#">Next</a></li>`
    }
    render() {

        return (<nav aria-label="Page navigation example" className="mt-4 d-flex justify-content-center" id="pagination">
            <ul className="pagination" dangerouslySetInnerHTML={{ __html: this.create()}}>



            </ul>
        </nav>)
    }
}