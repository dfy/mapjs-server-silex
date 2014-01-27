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

    protected $predis;

    protected $mapRepository;

    protected $mapId;

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

        $redisParams = array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 2
        );

        $this->predis = new Predis\Client($redisParams);
        $this->mapRepository = new IdeaMap\Predis\MapRepository(
            new IdeaMap\Predis\Client($this->predis),
            new IdeaMap\CommandSerializer()
        );
    }

    /**
     * @BeforeScenario
     */
    public function cleanDB()//(ScenarioEvent $event)
    {
        $this->predis->flushDb();
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

    /**
     * @Given /^the "([^"]*)" idea map exists$/
     */
    public function theIdeaMapExists($mapName)
    {
        // do this via the app api, like in iCreateTheIdeaMap?

        $createCommand = new \IdeaMap\Command\CreateMap(
            array('name' => $mapName)
        );
        $this->mapId = $this->mapRepository->create($createCommand);
    }

    /**
     * @When /^I submit an idea$/
     */
    public function iSubmitAnIdea()
    {
        $data = new stdClass();
        $data->commands = array(
            new \IdeaMap\Command\AddIdeaToMap(array(
                'id' => 9,
                'parentId' => null
            ))
        );

        $this->browser->post(
            $this->baseUrl . '/map/' . $this->mapId,
            array(), // not specifying any headers
            json_encode($data)
        );
    }

    /**
     * @Then /^I should see the idea has been accepted for processing$/
     */
    public function iShouldSeeTheIdeaHasBeenAcceptedForProcessing()
    {
        $response = $this->browser->getLastResponse();

        $code = $response->getStatusCode();
        if ($code !== 202) {
            throw new RuntimeException("Expected response code 202, got $code");
        }
    }
}
