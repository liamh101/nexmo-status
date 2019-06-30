import React, { Component } from 'react';
import moment from 'moment';

class TableRow extends Component {
    constructor(props) {
        super(props);
        this.state = { link: process.env.BASE_URL + '/calls/' + this.props.call.id };
    }

    render() {
        return <tr>
            <td>{this.props.call.id}</td>
            <td>{moment(this.props.call.callStart).format('YYYY-MM-DD HH:MM:ss')}</td>
            <td>{this.props.call.callEnd ? moment(this.props.call.callEnd).format('YYYY-MM-DD HH:MM:ss') : 'Not Set'}</td>
            <td>{this.props.call.latestStatus.data.status}</td>
            <td><a href={this.state.link}><i className="fas fa-arrow-right"/></a></td>
        </tr>
    }
}

export default TableRow;