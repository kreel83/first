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
import {modal, searchLivreAddict, navItems, livreParAuteur} from './search';

selectCategory();
modal();
searchLivreAddict()
navItems()
livreParAuteur()





import React from 'react';
import ReactDOM from 'react-dom';
//import App from './components/app'
import Livre from './components/livre'
import SearchPage from './components/searchPage/searchPage'
//import {createStore} from 'redux'
//import Display from './test'


//let store = createStore(reducer)
//const rootElement = document.getElementById('root')
//ReactDOM.render(<App />, rootElement)
const livreTab = document.getElementById('react_livre_tab')
if (livreTab) {
    let books = $('#react_livre_tab').attr('data-books')
    const pagination = $('#react_livre_tab').attr('data-pagination')
    const search = $('#titre').val()
    books = JSON.parse(books);

    //ReactDOM.render(<Display search={search} page={1} />, livreTab)
    ReactDOM.render(<SearchPage search={search} page={1} />, livreTab);
}

const livreElement = document.getElementById('livre')
if (livreElement) {
    const slug = $('#livre').attr('data-slug')
    console.log(slug)
    ReactDOM.render(<Livre slug={slug}/>, livreElement)
}





console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

