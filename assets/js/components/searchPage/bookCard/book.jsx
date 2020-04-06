import React from 'React';

export default class Book extends React.Component{
    constructor(props) {
        super(props)
        this.details = props.details
    }

    handleClick = () => {
        const link = this.props.details.titre
        let slug = '/display/'+link
        slug = slug.split(' ').join('-')
        window.location = slug
    }


    render() {
        return (<div className="card card_livre bookCard" data-slug="{ this.props.details.titre }">
            <div className="card-body d-flex justify-content-center" onClick={this.handleClick}>
                <img src={ this.props.details.photo } alt="" width="80" height="125" />
            </div>
            <div className="card-footer">
                {this.props.details.titre}
            </div>
            <div className="card-footer">
                <p>{this.props.details.genre}</p>
                [<em>
                {this.props.details.auteur}
            </em>]
            </div>
        </div>)
    }
}