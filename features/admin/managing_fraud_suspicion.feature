@managing_fraud_suspicion
Feature: Adding fraud suspicion
    In order to store fraud suspicions
    As an Administrator
    I want to be able to add fraud suspicion

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has customer "john_doe@example.com" with placed order with number "#000000001"
        And the store has fraud suspicion related to order with number "#000000001"

    @ui
    Scenario: Updating fraud suspicion
        When I go to the update fraud suspicion with order number "#000000001" page
        And I fill the street with "Broadway 123"
        And I fill the city with "New York"
        And I update it
        Then I should be notified that the fraud suspicion has been successfully updated