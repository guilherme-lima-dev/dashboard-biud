import React, {Component} from 'react';
import client from "../service/client";
import {ApolloProvider} from "@apollo/client";
import {Col, Container, Row, Table} from "react-bootstrap";

import CardWithoutChart from "./charts/CardWithoutChart";
import CardWithChart from "./charts/CardWithChart";
import clientGraphQL from "../service/client";
import DASHBOARD from "../query/queryDashboard";
import CHARTS from "../query/queryCharts";

class Dashboard extends Component {
    constructor() {
        super();
        this.state = {charts: {}, dashboard: {}, loading1: true, loading2: true};
    }

    componentDidMount() {
        clientGraphQL
            .query({
                query: DASHBOARD,
            })
            .then((result) => {
                console.log(result);
                this.setState({dashboard: result.data.dashboard, loading1: result.loading})
            });
        clientGraphQL
            .query({
                query: CHARTS,
            })
            .then((result) => {
                console.log(result);
                this.setState({charts: result.data.charts, loading2: result.loading})
            });
    }

    render() {
        const loading1 = this.state.loading1;
        const loading2 = this.state.loading2;
        return (
            <ApolloProvider client={client}>

                <div>
                    <Container className={"d-block justify-content-center"} fluid>
                        {loading1 ? (
                            <div className={'row text-center d-flex justify-content-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div>
                                <Row className={"d-flex justify-content-center mb-3"}>
                                    <Col>
                                        <CardWithoutChart title={"R$ " + this.state.dashboard.valueTotal}
                                                          description={"Valor total das compras."}/>

                                    </Col>
                                    <Col>
                                        <CardWithoutChart title={this.state.dashboard.qtdClients}
                                                          description={"Quantidade de clientes do sistema."}/>

                                    </Col>
                                    <Col>
                                        <CardWithoutChart title={this.state.dashboard.qtdProduct}
                                                          description={"Quantidade de produtos cadastrados."}/>

                                    </Col>
                                </Row>
                                <Row className={"d-flex justify-content-center mt-2 mb-2"}>
                                    <Col>
                                        <CardWithoutChart title={this.state.dashboard.qtdPurchases}
                                                          description={"Quantidade de compras ralizadas."}/>

                                    </Col>
                                    <Col>
                                        <CardWithoutChart title={"R$ " + this.state.dashboard.valueTotalDiscounts}
                                                          description={"Valor total de descontos."}/>

                                    </Col>
                                    <Col>
                                        <CardWithoutChart title={"R$ " + this.state.dashboard.valueTotalProducts}
                                                          description={"Valor total de todos os produtos."}/>

                                    </Col>
                                </Row>
                                <Row className={"d-flex justify-content-center mt-5 mb-2"}>
                                    <Col>
                                        <CardWithChart
                                            data={this.state.charts.purchasesClient}
                                            title={"Valor total e médio de compras por cliente"}></CardWithChart>

                                    </Col>
                                    <Col>
                                        <CardWithChart
                                            data={this.state.charts.purchaseProduct}
                                            title={"Valor total e médio de compras por produto"}></CardWithChart>

                                    </Col>
                                </Row>
                            </div>
                        )}
                    </Container>
                </div>
            </ApolloProvider>
        )
    }
}

export default Dashboard;
