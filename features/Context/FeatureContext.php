<?php

namespace RPGBehat;

use AppKernel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\ORM\Tools\SchemaTool;
use GuzzleHttp\Client;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use RPGBundle\Entity\Player;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    const URL = 'nginx/app_test.php';
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
        $method = strtolower($httpMethod);
        $client = new Client();
        $this->response = $client->request(
            $method,
            self::URL . $resource,
            [
                'form_params' => $this->payload,
                'headers' => [
                    'X-Api-Token' => '123'
                ]
            ]
        );

    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe(string $httpStatus)
    {
        if ((string)$this->response->getStatusCode() !== $httpStatus) {
            throw new \Exception('HTTP code does not match ' . $httpStatus .
                ' (actual: ' . $this->response->getStatusCode() . ')');
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
     * @Then table row is:
     */
    public function tableRowIs(PyStringNode $string)
    {
        $repository = self::$container->get('doctrine')->getManager()->getRepository('RPGBundle:Player');
        /** @var Player $player */
        $player = $repository->findAll()[0];

        $expected = json_decode($string->getRaw(), true);
        Assert::assertEquals($expected['id'], $player->getId());
        Assert::assertEquals($expected['name'], $player->getName());
        Assert::assertEquals($expected['type'], $player->getType());
        Assert::assertNotNull($player->getToken());
    }

    /**
     * @Then there should be 2d json with :rows rows and :columns columns with cells of numbers
     */
    public function thereShouldBeDJsonWithRowsAndColumnsWithCellsOfNumbers(int $rows, int $columns)
    {
        $content = json_decode($this->response->getBody()->getContents());
        Assert::assertEquals($rows, count($content));
        foreach ($content as $row) {
            Assert::assertEquals($columns, count($row));
            foreach ($row as $cell) {
                Assert::assertTrue($cell >= 1 && $cell <= $columns);
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
        $data = $this->response->getBody()->getContents();
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
        $player->setSkillPoints($player->getSkillPoints() + 1);

        $em->persist($player);
        $em->flush();
    }

    /**
     * @Given /^I should have (\d+) skillpoints$/
     */
    public function iShouldHaveSkillpoints(int $points)
    {
        $em = self::$container->get('doctrine')->getManager();
        $repository = $em->getRepository('RPGBundle:Player');
        /** @var Player $player */
        $player = $repository->findOneBy(['token' => '123']);

        Assert::assertEquals($points, $player->getSkillPoints());
    }
}
