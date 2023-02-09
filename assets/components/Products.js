// ./assets/js/components/Users.js

import React, {Component} from 'react';
import client from "../service/clientProducts";
import LIST_PRODUCTS from "../query/queryProducts";
import {ApolloProvider} from "@apollo/client";

class Products extends Component {
    constructor() {
        super();
        this.state = { products: [], loading: true};
    }

    componentDidMount() {
        this.getProducts();
    }

    getProducts() {
        client
        .query({
            query: LIST_PRODUCTS
        })
        .then((result) => {
            console.log(result);
            this.setState({ products: result.data.products_collection.products, loading: result.loading})
        });
    }

    render() {
        const loading = this.state.loading;
        return(
            <ApolloProvider client={client}>
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center"><span>List of products</span>Created with <i
                                className="fa fa-heart"></i> by Guilherme</h2>
                        </div>
                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                { this.state.products.map(product =>
                                    <div className="col-md-10 offset-md-1 row-block" key={product.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="media">
                                                    <div className="media-body">
                                                        <h4>{product.name} | R${product.price}</h4>
                                                    </div>
                                                    <div className="media-right align-self-center">
                                                        <a href="#" className="btn btn-default">Buy</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
            </ApolloProvider>
        )
    }
}
export default Products;
