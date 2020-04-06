import React from "react";
import ReactDom from "react-dom";

export default class Couverture extends React.Component {

    constructor(props) {
        super(props)

    }



    render() {
        return (
            <div>
                <img src={ this.props.photo } alt="" width="200"/>
                <p className="auteur">
                    { this.props.auteur}
                </p>
            </div>

        )
    }
}