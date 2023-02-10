import { gql } from "@apollo/client";

const DASHBOARD = gql`
    query{
        dashboard{
            valueTotal,
            qtdClients,
            qtdProduct,
            qtdPurchases,
            valueTotalDiscounts,
            valueTotalProducts
        }
    }
`;

export default DASHBOARD;