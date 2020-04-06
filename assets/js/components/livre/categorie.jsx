import React from "react";
import ReactDom from "react-dom";

export default class Categorie extends React.Component {

    constructor(props) {
        super(props)

    }



    render() {
        return (
            <div className="categorie">
                { this.props.categorie }
            </div>
        )
    }
}