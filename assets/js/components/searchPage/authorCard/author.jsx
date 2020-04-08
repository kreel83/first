import React, {useState} from 'React';
import Modal from './modal';

export default class Author extends React.Component{
    constructor(props) {
        super(props)
        this.details = props.details
        this.state = { isOpen: false };
    }

    componentWillMount() {
        if (this.details.photo == 'none') {
            this.details.photo='/img/avatar.png'
        }
    }


    toggleModal = () => {
        console.log("modal")
        this.setState({
            isOpen: !this.state.isOpen
        });

    }

    lanceModal = () => { console.log('lance')

    }



    render() {
        return (<div className="card card_livre bookCard" data-slug="{ this.props.details.titre }" data-toggle="modal" data-target=".exampleModal">
            <div className="card-body d-flex justify-content-center">
                <img src={ this.props.details.photo } alt="" width="125"  />
            </div>
            <div className="card-footer">
                {this.props.details.nom}
            </div>
            <Modal show={this.state.isOpen}
                   onClose={this.toggleModal}>
                Here's some content for the modal
            </Modal>
        </div>)
    }
}