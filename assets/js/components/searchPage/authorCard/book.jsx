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
        return (<div className="card card_livre bookCard">
            <h1>livre</h1>

        </div>)
    }
}