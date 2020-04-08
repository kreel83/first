import React, {useState, useEffect} from "react"
import Book from "./test-book"
import Pagination from "./test-pagination";

//import {createStore} from "redux/index";

const Display = ({search, page}) => {

    const  [books, setBooks] = useState(0)
    const  [nbBook, setNbBook] = useState(1)


    useEffect(() => {
        creation()
    }, [])


    const creation = (page = 1) => {
        const myurl = '/google/rechercheLivreaddict/' + search.trim() + '/' + page
        console.log(myurl)
        fetch(myurl)
            .then((response) => response.json())
            .then((data) => {
                setBooks(data.books)
                setNbBook(data.nbBook)
            })
    }


    let liste

    if (books.constructor === Array ) {
        liste = books.map((book, index) => <Book key={index} book={book} />)

    }



    return (
        <div>
        <Pagination pages={nbBook} action={creation()}/>
            { liste }
        </div>

    )
}

export default Display