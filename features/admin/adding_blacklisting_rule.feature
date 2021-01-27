@managing_blacklisting_rules
Feature: Adding blacklisting rules
    In order to manage blacklisting rules
    As an Administrator
    I want to be able to add new blacklisting rules

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has a customer group "Retail"
        And the store has a customer group "Wholesale"

    @ui
    Scenario: Adding blacklisting rule
        When I go to the create blacklisting rule page
        And I fill the rule name with "Country and firs name"
        And I select "Country" and "Last name" as rule attributes
        And I fill the permittedStrikes with "2"
        And I select "United States" as channels
        And I select "Retail" and "Wholesale" as customer groups
        And I want to this blacklisting rule will be applied to unassigned customers
        And I check enabled
        And I add it
        Then I should be notified that the blacklisting rule has been created

    @ui
    Scenario: Trying to add block with blank data
        When I go to the create blacklisting rule page
        And I try to add it
        Then I should be notified that "rule name, permitted strikes" fields cannot be blank

    @ui
    Scenario: Trying to add block with too long data
        When I go to the create blacklisting rule page
        And I fill "Rule name" fields with 256 characters
        And I try to add it
        Then I should be notified that "rule name" fields are too long

