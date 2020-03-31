import React from "react";
import Book from "./book";

export default class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            'test' : 'coucou',
            'books' : []
        }
    }


    componentDidMount() {
        this.setState({"test": "Coucou !"})
        $.get({
            url: '/google/ajax',
            success: function (data) {
                this.setState({"books": JSON.parse(data)})
                console.log(this.state.books[0])
            }.bind(this)
        });
    }


    render() {
        let bks = this.state.books
        var liste = bks.map((book, i) => {
            console.log(book)
            return (
                <Book key={i} book={book}></Book>
            )
            /*                return (
                                <div className="row" key={i}>

                                <div className="col-3" >
                                    <p>{book.titre}</p>
                                    <p>{book.auhor}</p>

                                </div>
                                    <div className="col">
                                        <p>{book.description}</p>
                                    </div>
                                </div>
                            )*/
        })

        return (
            <div className="app">
                <h1>{ this.state.test }</h1>
                <div className="liste">
                    {liste}
                </div>
            </div>)
    }
}