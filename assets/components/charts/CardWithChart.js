import React from 'react';
import { BarChart, Bar, Cell, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';
import Card from "react-bootstrap/Card";
import {Container} from "react-bootstrap";

export default function CardWithChart(props){
    return (
        <Card style={{ width: '35rem' }}>
            <Card.Body className={"text-center"}>
                <Card.Title className={"text-center"}>{props.title}</Card.Title>
                {/*<Card.Subtitle className="mb-2 text-muted">Valor médio de compras por cliente</Card.Subtitle>*/}
                <Container className={"pt-3"}>
                    <BarChart
                        width={500}
                        height={300}
                        data={props.data}
                        margin={{
                            top: 5,
                            right: 30,
                            left: 20,
                            bottom: 5,
                        }}
                    >
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="name" />
                        <YAxis />
                        <Tooltip />
                        <Legend />
                        <Bar dataKey="Total" fill="#DA1C5C" />
                        <Bar dataKey="Media" fill="#A727BF" />
                    </BarChart>
                </Container>
            </Card.Body>
        </Card>


    );
}
