@managing_blacklisting_rules
Feature: Adding blacklisting rules
    In order to manage blacklisting rules
    As an Administrator
    I want to be able to add new blacklisting rules

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @javascript
    Scenario: Adding blacklisting rule
        When I go to the create blacklisting rule page
        And I fill the rule name with "Country and full name"
        And I select "Country", "First name" and "Last name" as rule attributes
        And I fill the permittedStrikes with "2"
        And I check "Fashion Web Store"
        And I select "Retail" and "Wholesale" as customer groups
        And I check "Enabled"
        And I add it
        Then I should be notified that the blacklisting rule has been created

#    @ui
#    Scenario: Trying to add block with blank data
#        When I go to the create blacklisting rule page
#        And I try to add it
#        Then I should be notified that "Rule name" fields cannot be blank
#
#    @ui
#    Scenario: Trying to add block with too long data
#        When I go to the create blacklisting rule page
#        And I fill "Rule name" fields with 256 characters
#        And I try to add it
#        Then I should be notified that "Rule name" fields are too long

