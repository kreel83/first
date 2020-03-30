/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import {selectCategory} from './book.js';
import {modal} from './search';

selectCategory();
modal();

import React from 'react';
import ReactDOM from 'react-dom';
import Book from './components/book'

class App extends React.Component {
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


const rootElement = document.getElementById('root')
ReactDOM.render(<App />, rootElement)


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

