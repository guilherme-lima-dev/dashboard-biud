import React from 'react';
import Card from "react-bootstrap/Card";

export default function CardWithoutChart(props){
    return (
        <Card>
            <Card.Body>
                <Card.Title>{props.title}</Card.Title>
                <Card.Subtitle className="mb-2 text-muted">{props.description}</Card.Subtitle>
            </Card.Body>
        </Card>


    );
}
