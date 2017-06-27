<?php

namespace RPGBehat;

use AppKernel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use RPGBundle\Entity\Player;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    const URL = 'http://nginx/app_test.php';
    /** @var ContainerInterface */
    private static $container;
    /** @var array */
    private $payload;
    /** @var ResponseInterface */
    private $response;

    /**
     * @BeforeSuite
     */
    public static function bootstrapSymfony()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        require_once __DIR__ . '/../../app/AppKernel.php';
        $kernel = new AppKernel('test', true);
        $kernel->boot();
        self::$container = $kernel->getContainer();
    }

    /**
     * @Given I reseed the database
     */
    public function iReseedTheDatabase()
    {
        $em = self::$container->get('doctrine')->getManager();
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $tool = new SchemaTool($em);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = json_decode($string->getRaw(), true);
        Assert::assertTrue(json_last_error() == JSON_ERROR_NONE);
        Assert::assertTrue(count($this->payload) > 0);
    }

    /**
     * @When I request :httpMethod :resource
     */
    public function iRequest(string $httpMethod, string $resource)
    {
        /** @var \Symfony\Component\BrowserKit\Client $client */
        $client = $this->getSession()->getDriver()->getClient();
        $client->request(
            $httpMethod,
            self::URL . $resource,
            $this->payload ?: [],
            [],
            [
                'HTTP_X-Api-Token' => '123'
            ]
        );
        $this->response = $client->getResponse();
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe(string $httpStatus)
    {
        if ((string)$this->getSession()->getDriver()->getStatusCode() !== $httpStatus) {
            throw new \Exception('HTTP code does not match ' . $httpStatus .
                ' (actual: ' . $this->getSession()->getDriver()->getStatusCode() . ')');
        }
    }

    /**
     * @Then there are :totalRows rows in :entity
     */
    public function thereAreRowsInDatabaseTable(int $totalRows, string $entity)
    {
        $repository = self::$container->get('doctrine')->getManager()->getRepository('RPGBundle:' . $entity);
        Assert::assertTrue(count($repository->findAll()) === $totalRows);
    }

    /**
     * @Then there should be 2d json with :rows rows and :columns columns with cells of numbers
     */
    public function thereShouldBeDJsonWithRowsAndColumnsWithCellsOfNumbers(int $rows, int $columns)
    {
        $content = $this->getSession()->getDriver()->getClient()->getResponse()->getContent();
        $content = json_decode($content);

        Assert::assertEquals($rows, count($content));
        foreach ($content as $row) {
            Assert::assertEquals($columns, count($row));
            foreach ($row as $cell) {
                Assert::assertTrue($cell >= 1 && $cell <= $columns * 2);
            }
        }
    }

    /**
     * @Given I am a test user
     */
    public function iAmATestUser()
    {
        $em = self::$container->get('doctrine')->getManager();
        $repository = $em->getRepository('RPGBundle:Player');
        if (!$repository->findBy(['token' => '123'])) {
            $player = new Player();
            $player->setName('test')
                ->setType('test')
                ->setToken('123');

            $em->persist($player);
            $em->flush();
        }
    }

    /**
     * @Given /^it should return:$/
     */
    public function itShouldReturn(PyStringNode $string)
    {
        $data = $this->getSession()->getDriver()->getClient()->getResponse()->getContent();
        Assert::assertJsonStringEqualsJsonString($string->getRaw(), $data);
    }

    /**
     * @Given /^I get a skillpoint$/
     */
    public function iGetASkillpoint()
    {
        $em = self::$container->get('doctrine')->getManager();
        $repository = $em->getRepository('RPGBundle:Player');
        /** @var Player $player */
        $player = $repository->findOneBy(['token' => '123']);
        $player->setSkillPoints(1);

        $em->persist($player);
        $em->flush();
        $em->detach($player);
    }

    /**
     * @Given /^I am lv (\d+)$/
     */
    public function iAmLv($arg1)
    {
        $em = self::$container->get('doctrine')->getManager();
        $repository = $em->getRepository('RPGBundle:Player');
        /** @var Player $player */
        $player = $repository->findOneBy(['token' => '123']);
        $player->setLevel($arg1);

        $em->persist($player);
        $em->flush();
        $em->detach($player);
    }

    /**
     * @Given /^I am dead$/
     */
    public function iAmDead()
    {
        $em = self::$container->get('doctrine')->getManager();
        $repository = $em->getRepository('RPGBundle:Player');
        /** @var Player $player */
        $player = $repository->findOneBy(['token' => '123']);
        $player->setHealth(0);

        $em->persist($player);
        $em->flush();
        $em->detach($player);
    }

    /**
     * @Given /^score list should have (\d+) times:$/
     */
    public function scoreListShouldHaveTimes($arg1, PyStringNode $string)
    {
        $criteria = json_decode($string->getRaw(), true);
        $repository = self::$container->get('doctrine')->getManager()->getRepository('RPGBundle:Score');
        $scores = $repository->findBy($criteria);

        Assert::assertEquals($arg1, count($scores));
    }

    /**
     * @Given /^table "([^"]*)" row is:$/
     */
    public function tableRowIs1($arg1, PyStringNode $string)
    {
        $repository = self::$container->get('doctrine')->getManager()->getRepository($arg1);
        $data = $repository->findAll()[0];

        $expected = json_decode($string->getRaw(), true);
        foreach ($expected as $key => $value) {
            $method = 'get'.ucfirst($key);
            Assert::assertEquals($value, $data->$method());
        }
    }

    /**
     * @Given /^table "([^"]*)" row is empty$/
     */
    public function tableRowIsEmpty($arg1)
    {
        $repository = self::$container->get('doctrine')->getManager()->getRepository($arg1);
        $data = $repository->findAll();

        Assert::assertEquals(0, count($data));
    }
}
