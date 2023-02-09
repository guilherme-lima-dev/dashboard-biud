import { ApolloClient, InMemoryCache } from "@apollo/client";

const clientProducts = new ApolloClient({
    uri: "http://api-symfony-graphql.info/graphql/",
    cache: new InMemoryCache(),
});

export default clientProducts;