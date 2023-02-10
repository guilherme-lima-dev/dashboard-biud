import { ApolloClient, InMemoryCache } from "@apollo/client";

const client = new ApolloClient({
    uri: "http://desafio-guilherme.info/graphql/",
    cache: new InMemoryCache(),
});

export default client;