Feature:
    Client list

    Scenario: It gets a list of clients
        When I request "/api/v1/clients"
        Then the response should be valid
        Then the response data is a array of length 8
        Then the response data index 0 as values:
            | name  | Test Client updated |

        When lo que sea
