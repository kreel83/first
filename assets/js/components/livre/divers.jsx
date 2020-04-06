import React from "react";
import ReactDom from "react-dom";

export default class Divers extends React.Component {

    constructor(props) {
        super(props)

    }

    render() {
        return (
                <div>
                    <p className="details">
                        date de sortie  : { this.props.divers.dateSortie } | { this.props.divers.pages} pages | ISBN : { this.props.divers.isbn }
                    </p>
                </div>
        )
    }
}