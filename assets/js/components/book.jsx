import React from "react";

export default class Book extends React.Component {
    constructor (props) {
        super(props);
        this.state = {

            book: {
                title: props.title,
                author: props.author,
                description: props.description

            },
            test: this.loadNotesFromServer()
        }
    }

    components(b) {
        console.log(b)

    }

    loadNotesFromServer() {
        $.get({
            url: '/google/ajax',
            success: function (data) {
                const datas = JSON.parse(data);

                this.components(datas)

            }.bind(this)
        });
    }
    render() {
        return (<div className="row">
            <div className="col-3">
                <h6>{this.state.book.title}</h6>
                <p>{this.state.book.author}</p>
            </div>
            <div className="col-2">
                {this.state.test}
            </div>
            <div className="col">
                <p>
                    {this.state.book.description}
                </p>
            </div>
        </div>)
    }
}