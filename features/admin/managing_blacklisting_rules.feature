@managing_blacklisting_rules
Feature: Managing blacklisting rules
    In order to decide when the customers become blacklisted
    As an Administrator
    I want to be able to manage existing blacklisting rules

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @fail
    Scenario: Deleting block
        Given there is a blacklisting rule in the store
        When I go to the blacklisting rule page
        And I delete this blacklisting rule
        Then I should be notified that the blacklisting rule has been deleted
        And I should see empty list of blacklisting rules

    @ui
    Scenario: Updating blacklisting rule
        Given there is a blacklisting rule with "Country" name and "3" permitted strikes and "country" as a rule attributes
        When I go to the update "Country" blacklisting rule page
        And I fill the rule name with "Company"
        And I update it
        Then I should be notified that the blacklisting rule has been successfully updated

    @ui
    Scenario: Disabling blacklisting rule
        Given there is a blacklisting rule with "BitBagRule" name and "2" permitted strikes and "country" as a rule attributes
        When I go to the update "BitBagRule" blacklisting rule page
        And I disable it
        And I update it
        Then I should be notified that the blacklisting rule has been successfully updated
        And blacklisting rule "BitBagRule" should be disabled