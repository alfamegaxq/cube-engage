Feature: Map
  Scenario: Generating new map to explore
  Given I reseed the database
  Given I am a test user
  Given I am lv 6
  Given I have the payload:
  """
{"name": "test"}
  """
  Given I request "POST" "/api/player/login"
  When I request "GET" "/api/secure/map"
  Then the response status code should be 200
  And there should be 2d json with 6 rows and 6 columns with cells of numbers
