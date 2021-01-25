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
        And I am a logged in customer
        And there is a customer "francis@underwood.com" that placed an order "#00000022"
        And the customer bought a single "PHP T-Shirt"
        And the customer set the billing address as "Francis Underwood", "Groove Street", "91920", "Los Angeles", "United States"
        And the customer chose "Free" shipping method to "United States" with "Cash on Delivery" payment
        And the order "#00000022" is marked as suspicious by fake "billing" address

    @ui
    Scenario: Successfully complete checkout addressing step
        Given I have product "PHP Pullover" in the cart
        And there is a blacklisting rule with "Country" name and "3" permitted strikes and "country" as a rule attributes
        Then I am at the checkout addressing step
        And I specify the billing address as "Francis Underwood", "Groove Street", "91920", "United States" for "Francis Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @ui
    Scenario: Blocking users on checkout by manual blacklisting rules
        Given I have product "PHP Blouse" in the cart
        And there is a blacklisting rule with "Country" name and "1" permitted strikes and "country" as a rule attributes
        And I am at the checkout addressing step
        And I specify the billing address as "Francis Underwood", "Groove Street", "91920", "United States" for "Francis Underwood"
        And I complete the addressing step
        Then I should be notified that something went wrong
        And I should be at the checkout addressing step
