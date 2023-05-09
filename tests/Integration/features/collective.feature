Feature: collective

  Scenario: Create a collective and add members
    When user "jane" creates collective "BehatCollective"
    And user "alice" joins circle "BehatCollective" with owner "jane"
    Then user "jane" sees collective "BehatCollective"
    And user "alice" sees collective "BehatCollective"
    And user "jane" sees pagePath "Readme.md" in "BehatCollective"
    And user "alice" sees pagePath "Readme.md" in "BehatCollective"
    And user "john" doesn't see collective "BehatCollective"

  Scenario: Trash an owned collective
    When user "jane" trashes collective "BehatCollective"

  Scenario: Fail to delete a circle via Circles API
    Then user "jane" fails to delete circle "BehatCollective"

  Scenario: Delete an owned trashed collective+circle
    When user "jane" deletes collective+circle "BehatCollective"
    Then user "jane" doesn't see collective "BehatCollective"
    And user "alice" doesn't see collective "BehatCollective"
