<?php
namespace Flosy\Bundle\UseCaseBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Flosy\Bundle\UseCaseBundle\Entity\Scenario;
use Flosy\Bundle\UseCaseBundle\Entity\UseCase;

/**
 * Description of ScenarioTest
 *
 * @author sylvain
 */
class ScenarioTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testInsertScenario()
    {
        $useCase = new UseCase();
        $useCase->setTitle('Inserting Scenario');
        $useCase->setPrecondition('Creating UseCase.');
        $useCase->setAim('Adding a scenario to a use case.');

        $scenario = new Scenario();
        $scenario->setName('Main scenario.');
        $scenario->setUseCase($useCase);

        $this->em->persist($useCase);
        $this->em->persist($scenario);

        $this->em->flush();

        $useCases = $this->em
            ->getRepository('FlosyUseCaseBundle:UseCase')
            ->findByTitle('Inserting Scenario')
        ;

        $this->assertCount(1, $useCases);
    }

    public function testDeleteRelatedUseCase()
    {
        $useCase = $this->em
            ->getRepository('FlosyUseCaseBundle:UseCase')
            ->findOneByTitle('Inserting Scenario')
        ;

        $this->em->remove($useCase);

        $this->em->flush();

        $useCases = $this->em
            ->getRepository('FlosyUseCaseBundle:UseCase')
            ->findByTitle('Inserting Scenario')
        ;

        $this->assertCount(0, $useCases);
    }
}
