import React from 'React';


export default class ElementPagination extends React.Component {
    constructor(props) {
        super(props)
        this.page = props.page

    }

    render() {
        return(
            <li className="page-item" data-position={this.props.page}><a className="page-link" href="#"
                                                            onClick={() => this.props.someMethod(this.props.page)}>{this.props.page}</a></li>
        )
    }
}