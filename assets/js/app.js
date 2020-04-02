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
import App from './components/app'
import Book from './components/book'



const rootElement = document.getElementById('root')
ReactDOM.render(<App />, rootElement)




console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

