import { gql } from "@apollo/client";

const LIST_PURCHASES = gql`
        query Purchase($codReference: String, $client: String, $value: Float, $date: DateTime){
            purchases_collection(
                codReference: $codReference,
                client: $client,
                value: $value,
                date: $date
            ){
                purchases{
                    id,
                    client{
                        name
                    },
                    codReference,
                    discounts,
                    value,
                    date

                }
            }
        }
    `;

export default LIST_PURCHASES;