@managing_fraud_suspicion
Feature: Adding fraud suspicion
    In order to store fraud suspicions
    As an Administrator
    I want to be able to add fraud suspicion

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has customer "john_doe@example.com" with placed order

    @ui
    Scenario: Adding fraud suspicion
        When I go to the create fraud suspicion page
        And I fill all required fields basing on customer "john_doe@example.com" address
#        And I click "Mark blacklisted" button
#        Then I should be notified that the customer has been successfully updated
#        And customer "john_doe@example.com" should be "blacklisted"
#        And I click "Mark neutral" button
#        Then I should be notified that the customer has been successfully updated
#        And customer "john_doe@example.com" should be "neutral"