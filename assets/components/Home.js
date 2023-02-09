// ./assets/js/components/Home.js

import React, {Component} from 'react';
import {Route, Routes, Navigate, Link} from 'react-router-dom';
import Users from './Users';
import RickMorty from './RickMorty';
import {ApolloProvider} from "@apollo/client";
import client from "../service/rickmorty";
import clientProducts from "../service/clientProducts";
import Products from "./Products";

class Home extends Component {

    render() {
        return (
            <div>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <Link className={"navbar-brand"} to={"/"}> Symfony React Project </Link>
                    <div className="collapse navbar-collapse" id="navbarText">
                        <ul className="navbar-nav mr-auto">
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/users"}> Users </Link>
                            </li>
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/products"}> Products </Link>
                            </li>
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/rickmorty"}> API Rick n Morty </Link>
                            </li>
                        </ul>
                    </div>
                </nav>

                <Routes>
                    <Route path="/" element={<Navigate exact to="/users"/>}/>
                    <Route path="/users" element={<Users/>}/>
                    <Route path="/products" element={
                        <ApolloProvider client={clientProducts}>
                            <Products/>
                        </ApolloProvider>
                    }/>
                    <Route path="/rickmorty" element={
                        <ApolloProvider client={client}>
                            <RickMorty/>
                        </ApolloProvider>
                    }/>
                </Routes>
            </div>
        )
    }
}

export default Home;
