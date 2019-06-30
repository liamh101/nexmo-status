import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Spinner } from 'react-bootstrap';
import TableRow from './tableRow';

class Table extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            items: [],
        }
    }

    componentDidMount() {
        fetch(process.env.BASE_URL + '/api/calls')
            .then(res => res.json())
            .then(result => {
                this.setState({isLoaded: true, items: result.data});
            })
    }

    render() {
        let emptyTableRow = null;

        if (!this.state.isLoaded) {
            return <Spinner animation="border" />;
        }

        if (!this.state.items.length) {
            emptyTableRow = <tr><td colSpan="5">No Calls Made</td></tr>
        }

        return <table className="table table-striped">
            <thead>
            <tr>
                <th>
                    Call Id
                </th>
                <th>
                    Start Date
                </th>
                <th>
                    End Date
                </th>
                <th>
                    Status
                </th>
                <th>
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            {this.state.items.map((value) => (
                <TableRow key={value.id} call={value}/>
            ))}
            {emptyTableRow}
            </tbody>
        </table>
    }
}

ReactDOM.render(<Table/>, document.getElementById('table'));