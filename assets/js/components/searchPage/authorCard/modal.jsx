import React from 'react';
import PropTypes from 'prop-types';

class Modal extends React.Component {

    componentDidMount() {
        $.post({
            url: '/google/listeLivres',
            dataType: 'json',
            data: "link=" + link,
            success: (data) => {
                console.log(data)
                const d = data.link
                for (let i=0; i<d.length; i++) {
                    //console.log(data.link[i][0])
                    let data = ""
                    if (d[i][1].includes('livre')) {
                        data = `<li><a href="${ d[i][1].replace('/biblio','').replace('.html','') }">${d[i][0]}</a></li>`
                    } else {
                        data = `<h5>${d[i][0]}</h5>`
                    }
                    $('.body-livres').append(data)
                }
            }
        })
    }



    render() {

       console.log(this.props.show)
        return (
            <div className="modal fade exampleModal" tabIndex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            ...
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" className="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}



export default Modal;