<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^I am an author$/
     */
    public function iAmAnAuthor()
    {
        //throw new PendingException();
        // @todo implement authentication
    }

    /**
     * @When /^I create the "([^"]*)" idea map$/
     */
    public function iCreateTheIdeaMap($name)
    {
        // post create command to api root

        throw new PendingException();
    }

    /**
     * @Then /^the idea map should be saved$/
     */
    public function theIdeaMapShouldBeSaved()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I should be notified about the map creation success$/
     */
    public function iShouldBeNotifiedAboutTheMapCreationSuccess()
    {
        throw new PendingException();
    }
}
