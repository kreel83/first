import React from 'React';

export default class ElementPagination extends React.Component {
    constructor(props) {
        super(props)
        this.search = props.search
        this.page = props.page
        this.state = {
            books: props.books
        }
    }

    handleClick =() => {
        const myurl = '/google/rechercheLivreaddict/' + this.props.search.trim() + '/' + this.props.page

        console.log(myurl)
        $.get({
            url: myurl

        })
            .done((data) => {
                console.log(data)

                this.setState({books: JSON.parse(data)});
                $('.content').empty()

            })
    }




    render() {
        return(
            <li className="page-item" data-position={this.props.page}><a className="page-link" href="#"
                                                            onClick={this.handleClick}>{this.props.page}</a></li>
        )
    }
}