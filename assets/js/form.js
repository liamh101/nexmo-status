import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PhoneInput from 'react-phone-number-input'
import { OverlayTrigger, Tooltip } from 'react-bootstrap';

class Form extends Component {
    constructor(props) {
        super(props);

        this.state = {
            message: '',
            type: '1',
        };

        this.handleMessageChange = this.handleMessageChange.bind(this);
        this.handleTypeChange = this.handleTypeChange.bind(this);
    }

    handleMessageChange(event) {
        this.setState({message : event.target.value});
    }

    handleTypeChange(event) {
        this.setState({type: event.target.value});
    }

    render() {
        return (
            <form>
                <div className="form-group">
                    <label htmlFor="message">Message</label>
                    <textarea id="message" name="message" value={this.state.message} onChange={this.handleMessageChange} className="form-control" type="text"/>
                </div>

                <div className="form-group">
                    <label htmlFor="number">
                        Caller Number (optional)
                            <OverlayTrigger
                                placement="top"
                                overlay={
                                    <Tooltip>
                                        This is the number used to {this.state.type === '1' ? 'call' : 'text'} your device, default number used if blank.
                                    </Tooltip>
                                }>
                                <span>
                                    <i className="fas fa-question-circle tooltip-padding"/>
                                </span>
                            </OverlayTrigger>
                    </label>
                    <PhoneInput
                        id="number"
                        name="number"
                        placeholder="Please enter number"
                        onChange={phone => this.setState({ phone })}
                        value={this.state.number}/>
                </div>

                <div className="form-group">
                    <div className="form-check">
                        <input id="call" name="type" type="radio" className="form-check-input" value="1" onChange={this.handleTypeChange} checked={this.state.type === '1'}/>
                        <label htmlFor="call" className="form-check-label">Make a Call</label>
                    </div>

                    <div className="form-check">
                        <input id="text" name="type" type="radio" className="form-check-input" value="2" onChange={this.handleTypeChange} checked={this.state.type === '2'}/>
                        <label htmlFor="text" className="form-check-label">Send a text</label>
                    </div>
                </div>

                <button type="submit" className="btn btn-primary">Submit</button>
            </form>
        );
    }
}

ReactDOM.render(<Form/>, document.getElementById('form'));