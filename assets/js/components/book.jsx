import React from "react";
import ReactDom from "react-dom";

export default class Book extends React.Component {

    constructor(props) {
        super(props)
        this.state = {isClick: false}
    }

    handleClick = () => {
        this.setState(state => ({
            isClick: !state.isClick
        }))
    }


    render() {
        return (
            <div>
            <div className="row">
                <div className="col-3" >
                    <p>{this.props.book.titre}</p>
                    <p>{this.props.book.author}</p>
                </div>
                <div className="col-8">
                    <p>{this.props.book.description}</p>
                </div>
                <div className="col">
                    <button className="btn btn-default" onClick={this.handleClick}>{(this.state.isClick) ? 'hide' : 'show' }</button>
                </div>

            </div>
            <hr/>
            </div>
        )
    }
}