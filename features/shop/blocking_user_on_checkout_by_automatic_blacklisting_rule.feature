@blocking_users_on_checkout
Feature: Blocking users on checkout
    In order to blocking of suspicious orders
    As a customer
    I will not be able to go to checkout shipping method step if my order will be suspicious

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt"
        And the store has a product "PHP Blouse"
        And the store has a product "PHP Pullover"
        And the store ships everywhere for free
        And the store allows paying with "Cash on Delivery"
        And there is a customer "Francis Underwood" identified by an email "francis@underwood.com" and a password "whitehouse"
        And I am logged in as "francis@underwood.com"
        And there is a customer "francis@underwood.com" that placed an order
        And the customer bought a single "PHP T-Shirt"
        And the customer chose "Free" shipping method to "United States" with "Cash on Delivery" payment

    @ui @javascript
    Scenario: Successfully complete checkout addressing step
        Given I have product "PHP Pullover" in the cart
        And there is a automatic blacklisting configuration "First configuration" with rule "orders" configured with count "2" and date modifier "1 day"
        And I am at the checkout addressing step
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @ui @javascript
    Scenario: Blocking users on checkout by automatic blacklisting rules
        Given I have product "PHP Blouse" in the cart
        And there is a automatic blacklisting configuration "First configuration" with rule "orders" configured with count "1" and date modifier "1 day"
        And I am at the checkout addressing step
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be notified that something went wrong
        And I should be at the checkout addressing step
