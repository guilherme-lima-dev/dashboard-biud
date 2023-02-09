import { gql } from "@apollo/client";

const LIST_PRODUCTS = gql`
    query {
        products_collection{
            products {
                id,
                name,
                price,
            }
        }
    }
`;

export default LIST_PRODUCTS;