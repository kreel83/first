import React, {useState} from 'react';

const Element = ({page, action}) => {
    const  [books, setBooks] = useState(0)
    const  [nbBook, setNbBook] = useState(1)


        return(
            <li className="page-item" data-position={page}><a className="page-link" href="#" page={page} onClick={action}
                                                                         >{page}</a></li>
        )
    }


export default Element

