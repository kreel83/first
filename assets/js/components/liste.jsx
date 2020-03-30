import React from "react";
import Book from './com'
import ReactDom from "react-dom";
import Book from "./book";

export default class Liste extends React.Component {
    constructor(props) {
        super(props)
    }

    handle = () => {
        $.get({
            url: '/google/ajax',
            success: function (data) {
                console.log(data)
                return JSON.parse(data);

            }.bind(this)
        });
    }

    render() {
        let liste = this.handle;
        console.log(liste)
        /*        let div =  liste.map((data) => <div className="row">
                    <div className="col-3">
                        <h6>{data.title}</h6>
                        <p>{data.author}</p>
                    </div>

                    <div className="col">
                        <p>
                            {data.description}
                        </p>
                    </div>
                </div>)*/
        let div = liste.map((data) => {

        })

        return (<Liste>
                {div}
            </Liste>
        )
    }

}