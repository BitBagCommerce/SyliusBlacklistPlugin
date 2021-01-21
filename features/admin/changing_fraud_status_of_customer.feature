@managing_fraud_statuses_of_customers
Feature: Changing fraud status of customer
    In order to manage fraud statuses of customers
    As an Administrator
    I want to be able to change status of customer

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has customer "john_doe@example.com"

    @ui @javascript
    Scenario: Marking customer as blacklisted
        When I go to the customer page
        And I go to the update "john_doe@example.com" customer page
        And I select "Blacklisted" fraud status
        Then I update customer
        And I should be notified that the customer has been successfully updated

    @ui @javascript
    Scenario: Marking customer as whitelisted
        When I go to the customer page
        And I go to the update "john_doe@example.com" customer page
        And I select "Whitelisted" fraud status
        Then I update customer
        And I should be notified that the customer has been successfully updated