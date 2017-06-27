Feature: Score list

  Scenario: Don't save score
    Given I reseed the database
    Given I am a test user
    Given I have the payload:
  """
{"name": "test"}
  """
    Given I request "POST" "/api/player/login"
    When I request "POST" "/api/secure/score"
    Then the response status code should be 200
    And score list should have 0 times:
    """
{"name": "test"}
    """

  Scenario: Save score
    Given I reseed the database
    Given I am a test user
    Given I am dead
    Given I have the payload:
  """
{"name": "test"}
  """
    Given I request "POST" "/api/player/login"
    When I request "POST" "/api/secure/score"
    Then the response status code should be 200
    And score list should have 1 times:
    """
{"name": "test"}
    """
    And table "RPGBundle:Player" row is empty
