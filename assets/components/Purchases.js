// ./assets/js/components/Users.js

import React, {Component} from 'react';
import clientGraphQL from "../service/client";
import {ApolloProvider} from "@apollo/client";
import Card from "react-bootstrap/Card";
import {Button, Col, Container, Form, Row, Table} from "react-bootstrap";
import LIST_PURCHASES from "../query/queryPurchases";


class Purchases extends Component {
    constructor() {
        super();
        this.state = {purchases: [], loading: true};
    }


    componentDidMount() {
        this.getPurchases(null, null, 0, null);
    }

    getPurchases(codReference, client, value, date) {

        clientGraphQL
            .query({
                query: LIST_PURCHASES,
                variables: {
                    codReference, client, value, date
                }
            })
            .then((result) => {
                console.log(result);
                this.setState({purchases: result.data.purchases_collection.purchases, loading: result.loading})
            });
    }

    findPurchases = (e) => {
        e.preventDefault();
        this.setState({loading: true});
        var codReference = e.target.elements.codReference.value == "" ? null : e.target.elements.codReference.value;
        var client = e.target.elements.client.value == "" ? null : e.target.elements.client.value;
        var date = e.target.elements.date.value == "" ? null : e.target.elements.date.value;
        var value = e.target.elements.value.value == "" ? 0 : parseFloat(e.target.elements.value.value);
        this.getPurchases(codReference, client, value, date);
    }

    render() {
        const loading = this.state.loading;
        return <ApolloProvider client={clientGraphQL}>
            <div className={"w-100"}>
                <Container fluid className={"mb-3"}>
                    <Card style={{width: "100%"}}>
                        <Card.Header
                            style={{color: "#DA1C5C", fontWeight: "bold", letterSpacing: ".08rem", fontSize: "1.1rem"}}>Filtro
                            de compras</Card.Header>
                        <Card.Body>
                            <Form onSubmit={this.findPurchases}>
                                <Row>
                                    <Col>
                                        <Form.Group className="mb-3" controlId="formBasicPassword">
                                            <Form.Label>Código de Referência</Form.Label>
                                            <Form.Control name={"codReference"} type="text"
                                                          placeholder="Digite um código de referencia"/>
                                        </Form.Group>
                                    </Col>
                                    <Col>
                                        <Form.Group className="mb-3" controlId="formBasicEmail">
                                            <Form.Label>Cliente (nome, e-mail, Código)</Form.Label>
                                            <Form.Control name={"client"} type="text"
                                                          placeholder="Digite um nome, e-mail ou codigo"/>
                                        </Form.Group>
                                    </Col>
                                    <Col>
                                        <Form.Group className="mb-3" controlId="formBasicPassword">
                                            <Form.Label>A partir de:</Form.Label>
                                            <Form.Control name={"date"} type="date" placeholder="Escolha uma data"/>
                                        </Form.Group>
                                    </Col>
                                    <Col>
                                        <Form.Group className="mb-3" controlId="formBasicEmail">
                                            <Form.Label>Valor</Form.Label>
                                            <Form.Control name={"value"} type="text"
                                                          placeholder="Digite um valor ex: 9.99"/>
                                        </Form.Group>
                                    </Col>
                                </Row>
                                <div className={"w-100 d-flex justify-content-end"}>
                                    <Button variant="primary" type="submit">
                                        Pesquisar
                                    </Button>
                                </div>
                            </Form>
                        </Card.Body>
                    </Card>
                </Container>
                <Container fluid>
                    <Card style={{width: "100%"}}>
                        <Card.Body>
                            {loading ? (
                                <div className={'row text-center d-flex justify-content-center'}>
                                    <span className="fa fa-spin fa-spinner fa-4x"></span>
                                </div>
                            ) : (
                                <Table striped bordered hover size="sm">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Código de Referencia</th>
                                        <th>Descontos</th>
                                        <th>Valor</th>
                                        <th>Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {this.state.purchases.map((purchase) =>
                                        <tr key={purchase.id}>
                                            <td>{purchase.id}</td>
                                            <td>{purchase.client.name}</td>
                                            <td>{purchase.codReference}</td>
                                            <td>R$ {purchase.discounts}</td>
                                            <td>R$ {purchase.value}</td>
                                            <td>{purchase.date}</td>
                                        </tr>
                                    )}
                                    </tbody>
                                </Table>
                            )}

                        </Card.Body>
                    </Card>
                </Container>
            </div>
        </ApolloProvider>
    }
}

export default Purchases;
