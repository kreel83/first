import React from "react";
import ReactDom from "react-dom";

export default class Titre extends React.Component {

    constructor(props) {
        super(props)

    }



    render() {
        return (
            <div className="titre">
                { this.props.titre }
            </div>
        )
    }
}