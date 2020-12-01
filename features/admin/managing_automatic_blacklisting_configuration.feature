@managing_automatic_blacklisting_configuration
Feature: Adding a new automatic blacklisting configuration
    In order to give possibility to automatically detect fraud suspicion configuration
    As an Administrator
    I want to add a new automatic blacklisting configuration

#    Background:
#        Given the store operates on a single channel in "United States"
#        And there is a automatic blacklisting configuration "First configuration" with rule "payment_failures" configured with count "3" and date modifier "1 day"
#        And I am logged in as an administrator
#
#    @ui
#    Scenario: Removing automatic blacklisting configuration
#        When I delete a "First configuration" automatic blacklisting configuration
#        Then I should be notified that the automatic blacklisting configuration has been successfully deleted
#        And "First configuration" should no longer exist in the automatic blacklisting configuration registry
#
#    @ui
#    Scenario: Updating automatic blacklisting configuration
#        When I go to update configuration "First configuration" page
#        Then I fill configuration name with "First configuration updated"
#        And I change last rule count with "10"
#        And I update it
#        Then I should be notified that the automatic blacklisting configuration has been successfully updated