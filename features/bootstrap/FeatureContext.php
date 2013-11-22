<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Buzz\Message\Request;
use Buzz\Browser;

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
    protected $baseUrl = 'http://localhost:8989';

    protected $browser;

    protected $lastName;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
        $this->browser = new Browser();
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
        // {cmd: "create", name: "$name"}
        // {cmd: "create", content: {name: "$name"}} ?

        //$this->browser->call($this->baseUrl . '', 'GET');
        $postVars = array(
            'name' => $name
        );
        $this->browser->submit($this->baseUrl . '/api', $postVars, 'POST');
        $this->lastName = $name;
    }

    /*protected function lastStatusCode()
    {
        return $this->browser->getLastResponse()->getStatusCode();
    }*/

    /**
     * @Then /^the idea map should be saved$/
     */
    public function theIdeaMapShouldBeSaved()
    {
        $response = $this->browser->getLastResponse();

        $code = $response->getStatusCode();
        if ($code !== 200) {
            throw new RuntimeException("Expected response code 200, got $code");
        }

        $map = json_decode($response->getContent());
        if (!is_object($map)) {
            throw new RuntimeException("Could not decode response to JSON");
        }

        if (!$map->id || !is_numeric($map->id)) {
            throw new RuntimeException("Saved idea map has no ID");
        }

        if (!$map->name || $map->name != $this->lastName) {
            throw new RuntimeException("Expected map name {$this->lastName}, got {$map->name}");
        }
    }

    /**
     * @Given /^I should be notified about the map creation success$/
     */
    public function iShouldBeNotifiedAboutTheMapCreationSuccess()
    {
        throw new PendingException();
    }
}
