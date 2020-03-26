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
import ReactDom from 'react-dom';
import TodoList from './components/todoList'
import Book from './components/book'

const element = React.createElement(TodoList, {
    likes: 4
})
ReactDom.render(element, document.getElementById('todo'));



const book = React.createElement(Book)
document.querySelectorAll('.book').forEach((b)=> {
    setState({
        book.title = 'tt'
    })
    ReactDom.render(book, b)
})









console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

