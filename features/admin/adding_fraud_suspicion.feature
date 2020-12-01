@managing_fraud_suspicion
Feature: Adding fraud suspicion
    In order to store fraud suspicions
    As an Administrator
    I want to be able to add fraud suspicion

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt"
        And the store ships everywhere for free
        And the store allows paying with "Cash on Delivery"
        And there is a customer "john.doe@gmail.com" that placed an order "#00000022"
        And the customer bought a single "PHP T-Shirt"
        And the customer chose "Free" shipping method to "United States" with "Cash on Delivery" payment
        And I am logged in as an administrator
#
#    @ui
#    Scenario: Adding fraud suspicion
#        When I go to the create fraud suspicion page
#        And I fill all required fields basing on order "#00000022" address
#        And I add it
#        Then I should be notified that the fraud suspicion has been created
#
#    @ui
#    Scenario: Marking order as suspicion
#        When I go to the order with number "#00000022" page
#        And I click "Mark suspicious" button
#        Then I select "Billing address" as address type
#        And I add comment "The customer places too much orders"
#        And I add it
#        Then I should be notified that the fraud suspicion has been created