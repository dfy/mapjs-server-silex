<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Buzz\Message\Request;
use Buzz\Browser;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    protected $baseUrl = 'http://test.mapjs-server.local:8989';

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
        $this->mapRepository = new SimpleCommand\Predis\MapRepository(
            new SimpleCommand\Predis\Client($this->predis),
            new IdeaMapApp\CommandSerializer()
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

        $createCommand = new \IdeaMapApp\Command\CreateMap($mapName);
        $this->mapId = $this->mapRepository->create($createCommand);
    }

    /**
     * @When /^I submit an idea$/
     */
    public function iSubmitAnIdea()
    {
        $data = new stdClass();
        $data->commands = array(
            new \IdeaMapApp\Command\AddSubIdea(9, 'A sub-idea', null)
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
        //var_dump($response->getContent());

        $code = $response->getStatusCode();
        if ($code !== 202) {
            throw new RuntimeException("Expected response code 202, got $code");
        }
    }

    /**
     * @Then /^I should eventually see the idea has been saved$/
     */
    public function iShouldEventuallySeeTheIdeaHasBeenSaved()
    {
        for ($i = 0; $i < 3; ++$i) {
            $response = $this->browser->get($this->baseUrl . '/map-events/' . $this->mapId);

            $contentType = $response->getHeader('Content-Type');
            $expectedContentType = 'text/event-stream; charset=UTF-8';
            if ($contentType != $expectedContentType) {
                throw new \RuntimeException(
                    "Expected content type '$expectedContentType' but got '$contentType"
                );
            }

            $content = $response->getContent();
            var_dump($content);

            $lines = explode("\n", $content);
            if (count($lines) == 4 && is_int(strpos($lines[3], 'AddSubIdea'))) {
                return true;
            }

            sleep(1); // is there something in the behat api to wait?
        }

        throw new RuntimeException('AddSubIdea event not reported');
    }

    /**
     * @Given /^the "([^"]*)" idea map does not exist$/
     */
    public function theIdeaMapDoesNotExist($arg1)
    {
        // id of map that doesn't exist
        $this->mapId = 999;
    }

    /**
     * @Then /^I should see a "([^"]*)" error$/
     */
    public function iShouldSeeAError($errorType)
    {
        $response = $this->browser->getLastResponse();
        $code = $response->getStatusCode();

        switch ($errorType) {

            case 'map not found':
                if ($code !== 404) {
                    throw new RuntimeException("Expected response code 404, got $code");
                }
                break;

            default:
                throw new \RuntimeException("Undefined error type '$errorType'");
        }
    }
}
