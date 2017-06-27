#Feature: Map
#  Scenario: Generating new map to explore
#  Given I reseed the database
#  Given I am a test user
#  Given I am lv 6
#  When I request "GET" "/api/secure/map/6"
#  Then the response status code should be 200
#  And there should be 2d json with 6 rows and 6 columns with cells of numbers
