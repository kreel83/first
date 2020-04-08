import React from 'react';

const Book = (book) => {

    return (<div className="row mb-2">
        <div className="col-md-3">
            <img src={book.book.photo} alt="" width="80"/>
        </div>
        <div className="col-md-9">
            <h5>titre : {book.book.titre} </h5>
            <p>auteur : {book.book.auteur} </p>
        </div>


    </div>)
}

export default Book