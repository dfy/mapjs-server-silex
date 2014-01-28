Feature: author can update an idea map
  In order to keep track of my group's ideas
  As an author (brainstormer? mind mapper?)
  I want to update an existing idea map

  Scenario: Successfully adding a sub idea
    Given I am an author
    And the "Interesting stuff" idea map exists
    When I submit an idea
    Then I should see the idea has been accepted for processing
    And I should eventually see the idea has been saved

  Scenario: Failing to add a sub idea to a non-existent map
    Given I am an author
    And the "Interesting stuff" idea map does not exist
    When I submit an idea
    Then I should see a "map not found" error