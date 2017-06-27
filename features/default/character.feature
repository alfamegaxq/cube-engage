#Feature: Character creation
#
#  Scenario: Creating a new Character
#  Given I reseed the database
#  Given I have the payload:
#  """
#{"name": "username", "type": "red"}
#  """
#  When I request "POST" "/api/player"
#  Then the response status code should be 200
#  And there are 1 rows in "Player"
#  And table "RPGBundle:Player" row is:
#  """
#{"id":1,"type":"red","name":"username"}
#  """
#
#  Scenario: get player info
#    Given I am a test user
#    When I request "GET" "/api/player/123"
#    Then the response status code should be 200
#    And it should return:
#"""
#{"id":2,"type":"test","name":"test","token":"123","level":1,"xp":0,"score":0,"multiplier":1,"health":10,"attackPoints":1,"nextLevelXpNeeded":1000,"skillPoints":0,"leveledUp":false,"maxHealth":10}
#"""
#
#  Scenario: login with player name
#    Given I am a test user
#    Given I have the payload:
#  """
#{"name": "test"}
#  """
#    When I request "POST" "/api/player/login"
#    Then the response status code should be 200
#    And it should return:
#"""
#{"id":2,"type":"test","name":"test","token":"123","level":1,"xp":0,"score":0,"multiplier":1,"health":10,"attackPoints":1,"nextLevelXpNeeded":1000,"skillPoints":0,"leveledUp":false,"maxHealth":10}
#"""
#
#  Scenario: Increase attack points
#    Given I reseed the database
#    Given I am a test user
#    Given I get a skillpoint
#    Given I have the payload:
#  """
#{"name": "test"}
#  """
#    Given I request "POST" "/api/player/login"
#    When I request "POST" "/api/player/upgrade/attack"
#    Then the response status code should be 200
#    And it should return:
#    """
#{"id":1,"type":"test","name":"test","token":"123","level":1,"xp":0,"score":0,"multiplier":1,"health":10,"attackPoints":2,"nextLevelXpNeeded":1000,"skillPoints":0,"leveledUp":false,"maxHealth":10}
#    """
#
#  Scenario: Increase multiplier points
#    Given I reseed the database
#    Given I am a test user
#    Given I get a skillpoint
#    Given I have the payload:
#  """
#{"name": "test"}
#  """
#    Given I request "POST" "/api/player/login"
#    When I request "POST" "/api/player/upgrade/multiplier"
#    Then the response status code should be 200
#    And it should return:
#    """
#{"id":1,"type":"test","name":"test","token":"123","level":1,"xp":0,"score":0,"multiplier":2,"health":10,"attackPoints":1,"nextLevelXpNeeded":1000,"skillPoints":0,"leveledUp":false,"maxHealth":10}
#    """
