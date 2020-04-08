import React, {useState, useEffect} from "react"
import Element from "./test-element-pagination"

const Pagination =({pages, action}) => {

    let nbPage;


    nbPage = Math.trunc(pages / 10) + 1

    function create() {

        let pages = []
        for (let nb = 1; nb <= nbPage; nb++) {
            pages.push(<Element key={nb} page={nb} action={action}/>)

        }
        return pages
    }


    return (<nav aria-label="Page navigation example" className="mt-4 d-flex justify-content-center" id="pagination">
        <ul className="pagination">
            <li className="page-item" data-position="previous"><a className="page-link" href="#">Previous</a></li>
            { create() }
            <li className="page-item" data-position="next"><a className="page-link" href="#">Next</a></li>
        </ul>
    </nav>)

}

export default Pagination