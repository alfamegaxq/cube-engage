Feature: Character creation
  Scenario: Creating a new Character
  Given I reseed the database
  Given I have the payload:
  """
{"name": "username", "type": "red"}
  """
  When I request "POST" "/api/player"
  Then the response status code should be 200
  And there are 1 rows in "Player"
  And table row is:
  """
{"id":1,"type":"red","name":"username"}
  """
