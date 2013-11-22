Feature: author can create an idea map
  In order to keep track of my group's ideas
  As an author (brainstormer? mind mapper?)
  I want to create a new idea map

  Scenario: Successfully creating a map with a name
    Given I am an author
    When I create the "Interesting stuff" idea map
    Then the idea map should be saved
    #And I should be notified about the map creation success