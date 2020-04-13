import React from "react";
import Titre from "./livre/titre"
import Couverture from "./livre/couverture"
import Description from "./livre/description"
import Divers from "./livre/divers"
import Categorie from "./livre/categorie"

export default class Livre extends React.Component {

    constructor(props) {
        super(props)
        this.slug = props.slug;
        this.state =
            {
                isClick: false,
                details: []
            }
    }

    componentDidMount() {
        const page = 1
        const titre = this.props.slug;
        const myurl = '/react/livre/' + titre
        console.log(myurl)
        $.get({
            url: myurl,
            success: function (data) {
                this.setState({"details": JSON.parse(data)})
                console.log(this.state.details)
            }.bind(this)
        });
    }

    addWish = () => {

        $.post({
            url: '/add/wish',
            data: {'details' : this.state.details

            },
            success: function (data) {

                console.log(JSON.parse(data))
            }.bind(this)
        });
    }

    render() {
        const divers = {
            "isbn": this.state.details.isbn,
            "pages": this.state.details.pages,
            "categorie": this.state.details.genre,
            "dateSortie": this.state.details.dateSortie,
            "auteur": this.state.details.auteur
        }
        return (
            <>
                <div className="book">
                    <Categorie categorie={this.state.details.genre}/>
                    <hr/>
                    <Titre titre={this.state.details.titre}/>
                    <div className="row">
                        <div className="col-md-6">
                            <Couverture auteur={this.state.details.auteur} photo={this.state.details.couverture}/>

                        </div>
                        <div className="col-md-6">

                            <Description description={this.state.details.description}/>
                        </div>
                    </div>


                    <Divers divers={divers}/>
                </div>
                <div className="control mt-5">
                    <button className="btn btn-dark" onClick={this.addWish}>Ajouter à la whish list</button>
                </div>
            </>
        )
    }
}