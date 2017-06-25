Feature: Map
  Scenario: Generating new map to explore
  When I request "GET" "/api/map/6"
  Then the response status code should be 200
  And there should be 2d json with 6 rows and 6 columns with cells of numbers
