Feature: Login page
  Check if the login page is rendered

  Scenario: I want to log in
    Given I am an unauthenticated user
    When I request a login from "localhost:8000/"
    Then The results should include a button with class "btn-success"

  Scenario: I submit the form
