Feature: Place-finder API /places/{id}
  In order to get an overview of my account
  As an Advertiser
  I need to have a working dashboard

##  /places?...=...&...=...
  Scenario: Finding an existing place by array
    Given that I want to find a "Place" with:
      | Field  | Value |
      | online | 0     |
    Then the response status code should be 200
    And the response should be JSON
    And the response should contains 2 results

#  /places?...=...&...=...
  Scenario: Finding an existing place by array
    Given that I want to find a "Place" with:
      | Field  | Value |
      | online | 1     |
    Then the response status code should be 200
    And the response should be JSON
    And the response should contains 0 results

#  /places/1
  Scenario: Finding an existing place by id
    Given I send a GET request to "places/1"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals 1
    And the "create_dt" property equals "2014-12-29 15:25:15"
    And the "update_dt" property equals "2014-12-29 15:25:15"
    And the "name" property equals "The John Snow"
    And the "latitude" property equals 51.513389
    And the "longitude" property equals -0.136561
    And the "is_online" property equals false

#  /places/1
  Scenario: Finding an existing place by id
    Given that I want to find the "Place" identified by "1"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals 1
    And the "create_dt" property equals "2014-12-29 15:25:15"
    And the "update_dt" property equals "2014-12-29 15:25:15"
    And the "name" property equals "The John Snow"
    And the "latitude" property equals 51.513389
    And the "longitude" property equals -0.136561
    And the "is_online" property equals false

#  /places/0
  Scenario: Finding a no-existing place
    Given I send a GET request to "places/0"
    Then the response status code should be 404
    And the response should be JSON
    And the response reasonPhrase should be "Not Found"

# Create a new place
  Scenario: Create a new place
    Given that I want to create a new "Place" with json:
    """
      {
        "placefinder_bundle_domainbundle_place": {
          "name": "AWin",
          "latitude": 51.5082339,
          "longitude": -0.0673449
        }
      }
    """
#    Then the response status code should be 201
#    And that I want to find the "Place" identified by "3"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals 3
    And the "name" property equals "AWin"
    And the "latitude" property equals 51.5082339
    And the "longitude" property equals -0.0673449
    And the "is_online" property equals false

# Update a place
  Scenario: Update PARTIALLY a place
    Given that I want to update partially the "Place" identified by "3" with json:
    """
      {
        "placefinder_bundle_domainbundle_place": {
          "id": 3,
          "name": "AWin UPDATED"
        }
      }
    """
#    Then the response status code should be 201
#    And that I want to find the "Place" identified by "3"
    Then the response status code should be 200
    And the response should be JSON
    And the "id" property equals 3
#    And the "create_dt" property equals "2014-12-29 15:25:15"
#    And the "update_dt" property equals "2014-12-29 15:25:15"
    And the "name" property equals "AWin UPDATED"
    And the "latitude" property equals 51.5082339
    And the "longitude" property equals -0.0673449
    And the "is_online" property equals false

# Update a place
#  Scenario: Update a place
#    Given that I want to update the "Place" identified by "3" with json:
#    """
#      {
#        "id": 3,
#        "create_dt": "2015-05-26 14:15:43",
#        "update_dt": "2015-05-26 14:15:43",
#        "name": "AWin",
#        "latitude": 51.5082339,
#        "longitude": -0.0673449,
#        "is_online": true,
#        "place_categories": [ ]
#      }
#    """
##    Then the response status code should be 201
##    And that I want to find the "Place" identified by "3"
#    Then the response status code should be 200
#    And the response should be JSON
#    And the "id" property equals 3
##    And the "create_dt" property equals "2014-12-29 15:25:15"
##    And the "update_dt" property equals "2014-12-29 15:25:15"
#    And the "name" property equals "AWin"
#    And the "latitude" property equals 51.5082339
#    And the "longitude" property equals -0.0673449
#    And the "is_online" property equals true

# Soft delete a place
#  Scenario: Soft deleting a place
#    Given that I want to delete the "Place" identified by "3"
#    And that I want to find the "Place" identified by "3"
#    Then the response status code should be 404
