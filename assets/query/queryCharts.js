import { gql } from "@apollo/client";

const CHARTS = gql`
    query{
        charts{
            purchasesClient{
                name,
                Media,
                Total
            },
            purchaseProduct{
                name,
                Media,
                Total
            }
        }
    }
`;

export default CHARTS;