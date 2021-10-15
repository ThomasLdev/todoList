<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class HomePageContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    /**
     * @Given I am an unauthenticated user
     */
    public function iAmAnUnauthenticatedUser()
    {
        throw new PendingException();
    }

    /**
     * @When I request a login from :arg1
     */
    public function iRequestALoginFrom($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then The results should include a button with class :arg1
     */
    public function theResultsShouldIncludeAButtonWithClass($arg1)
    {
        throw new PendingException();
    }

}
