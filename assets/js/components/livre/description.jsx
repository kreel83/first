import React from "react";
import ReactDom from "react-dom";

export default class Description extends React.Component {

    constructor(props) {
        super(props)

    }
    render() {
        return (
            <div>
                <span dangerouslySetInnerHTML={{__html: this.props.description}} />
            </div>
        )
    }
}