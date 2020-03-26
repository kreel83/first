import React from "react";

export default class TodoList extends React.Component {
    constructor (props) {
        super(props);
        this.state = {
            likes : props.likes || 0
        }
    }
    render() {
        return (<div className="todolistStyle">{this.props.likes}</div>)
    }
}