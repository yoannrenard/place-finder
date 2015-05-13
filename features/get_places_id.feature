Feature: Place-finder API /places/{id}
  In order to get an overview of my account
  As an Advertiser
  I need to have a working dashboard

#  /places/1
  Scenario: Finding an existing place by id
    Given I request "places/1"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals "1"
    And the "create_dt" property equals "2014-12-29T15:25:15+0000"
    And the "update_dt" property equals "2014-12-29T15:25:15+0000"
    And the "name" property equals "The John Snow"
    And the "latitude" property equals "51.513389"
    And the "longitude" property equals "-0.136561"
    And the "is_online" property equals "0"

#  /places/1
  Scenario: Finding an existing place by id
    Given that I want to find the "Place" identified by "1"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals "1"
    And the "create_dt" property equals "2014-12-29T15:25:15+0000"
    And the "update_dt" property equals "2014-12-29T15:25:15+0000"
    And the "name" property equals "The John Snow"
    And the "latitude" property equals "51.513389"
    And the "longitude" property equals "-0.136561"
    And the "is_online" property equals "0"

#  /places/0
  Scenario: Finding a no-existing place
    Given I request "places/0"
    Then the response status code should be 404
    And the response should be JSON
    And the response reasonPhrase should be "Not Found"

#  /places?...=...&...=...
#  Scenario: Finding an existing place by array
#    Given that I want to find a "Place" with:
#      | Field | Value |
#      | id    | 1     |
#    Then the response status code should be 200
#    And the response should be JSON
#    And the "id" property equals "1"
#    And the "create_dt" property equals "2014-12-29T15:25:15+0000"
#    And the "update_dt" property equals "2014-12-29T15:25:15+0000"
#    And the "name" property equals "The John Snow"
#    And the "latitude" property equals "51.513389"
#    And the "longitude" property equals "-0.136561"
#    And the "is_online" property equals "0"

#  Scenario: Deleting a User
#    Given that I want to delete a "User"
#    And that its "name" is "Chris"
#    When I request "/user"
#    Then the "status" property equals "true"
