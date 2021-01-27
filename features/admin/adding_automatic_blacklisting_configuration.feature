@managing_automatic_blacklisting_configuration
Feature: Adding a new automatic blacklisting configuration
    In order to give possibility to automatically detect fraud suspicion configuration
    As an Administrator
    I want to add a new automatic blacklisting configuration

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Successfully adding a new automatic blacklisting configuration with max number of orders
        When I go to the create automatic blacklisting configuration page
        And I name it "First configuration"
        And I select "United States" as channels
        And I enable it
        And I add the "Max number of orders" rule configured with count "5" and "Per day" as date modifier
        And I do not want to add fraud suspicion row after exceeding limit
        And I add it
        Then I should be notified that the automatic blacklisting configuration has been created
        And the "First configuration" should appear in the registry

    @ui @javascript
    Scenario: Successfully adding a new automatic blacklisting configuration with max number of payment failures
        When I go to the create automatic blacklisting configuration page
        And I name it "Second configuration"
        And I select "United States" as channels
        And I enable it
        And I add the "Max number of payment failures" rule configured with count "3" and "Per day" as date modifier
        And I do not want to add fraud suspicion row after exceeding limit
        And I add it
        Then I should be notified that the automatic blacklisting configuration has been created
        And the "Second configuration" should appear in the registry

    @ui @javascript
    Scenario: Unsuccessfully adding a new automatic blacklisting configuration with max number of orders and max number of payment failures
        When I go to the create automatic blacklisting configuration page
        And I name it "Third configuration"
        And I select "United States" as channels
        And I enable it
        And I add the "Max number of payment failures" rule configured with count "3" and "Per day" as date modifier
        And I add the "Max number of orders" rule configured with count "5" and "Per day" as date modifier
        And I add it
        Then I should be notified that the store has to have some manual blacklisting rule