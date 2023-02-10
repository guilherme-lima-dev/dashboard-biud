// ./assets/js/components/Home.js

import React, {Component} from 'react';
import {Route, Routes, Navigate, Link} from 'react-router-dom';
import {ApolloProvider} from "@apollo/client";
import client from "../service/client";
import Purchases from "./Purchases";
import Dashboard from "./Dashboard";
import {Container, Nav, Navbar, NavDropdown} from "react-bootstrap";

class Home extends Component {

    render() {
        return (
            <div style={{background: "#fde6e9"}}>
                <Navbar bg="light" expand="lg">
                    <Container>
                        <Navbar.Brand href="#home"><Link className={"navbar-brand"} to={"/"} style={{color: "#DA1C5C"}}> Dashboard <b>BIUD</b> </Link></Navbar.Brand>
                        <Navbar.Toggle aria-controls="basic-navbar-nav" />
                        <Navbar.Collapse id="basic-navbar-nav">
                            <Nav className="me-auto">
                                <Nav.Link href={"/purchases"}> Compras </Nav.Link>
                            </Nav>
                        </Navbar.Collapse>
                    </Container>
                </Navbar>

                <section className="container-fluid p-5 mt-2 d-flex justify-content-center" style={{minHeight: "100vh"}}>
                    <Routes>
                        <Route path="/" element={<Navigate exact to="/dashboard"/>}/>
                        <Route path="/dashboard" element={
                            <ApolloProvider client={client}>
                                <Dashboard/>
                            </ApolloProvider>
                        }/>
                        <Route path="/purchases" element={
                            <ApolloProvider client={client}>
                                <Purchases/>
                            </ApolloProvider>
                        }/>
                    </Routes>
                </section>
            </div>
        )
    }
}

export default Home;
