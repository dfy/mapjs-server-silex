Feature: author can update an idea map
  In order to keep track of my group's ideas
  As an author (brainstormer? mind mapper?)
  I want to update an existing idea map

  Scenario: Successfully creating a map with a name
    Given I am an author
    And the "Interesting stuff" idea map exists
    When I submit an idea
    Then I should see the idea has been accepted for processing
    # And after a delay I should see the idea has been saved