import React, {useState} from 'React';


export default class Author extends React.Component{
    constructor(props) {
        super(props)
        this.details = props.details
        this.state = { isOpen: true };
    }

    componentWillMount() {
        if (this.details.photo == 'none') {
            this.details.photo='/img/avatar.png'
        }
    }

    handleClick = () => {
        console.log('click')
        const link = this.props.details.titre
        let slug = '/display/'+link
        slug = slug.split(' ').join('-')
        window.location = slug
    }

    addBook = () => {
       $(".les_livres").empty()

        $.post({
            url: '/google/listeLivres',
            dataType: 'json',
            data: "link=" + this.props.details.link,
            success: (data) => {
                console.log(data)
                const d = data.link
                for (let i=0; i<d.length; i++) {
                    //console.log(data.link[i][0])
                    let data = ""
                    if (d[i][1].includes('livre')) {
                        data = `<div onclick="this.handleClick()" class="card" style="cursor:pointer;margin:8px;width: 150px;padding: 16px;height: 200px">${d[i][0]}</div>`
                    }
                    $(".les_livres").append(data)
                }
            }
        })

    }



    render() {
        return (<div className="card author_card" onClick={this.addBook} hidden={!this.state.isOpen} >
            <div className="card-body d-flex justify-content-center">
                <img src={ this.props.details.photo } alt="" width="125"  />
            </div>
            <div className="card-footer">
                {this.props.details.nom}
            </div>
        </div>)
    }
}