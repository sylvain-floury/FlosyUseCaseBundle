<?php
namespace Flosy\Bundle\UseCaseBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of ProjectRepositoryTest
 *
 * @author sylvain
 */
class ProjectRepositoryTest extends WebTestCase
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

    public function testInsertProject()
    {
        $project = new \Flosy\Bundle\UseCaseBundle\Entity\Project();
        $project->setName('My Project');
        $project->setDescription('Project description.');

        $this->em->persist($project);
        $this->em->flush();

        $projects = $this->em
            ->getRepository('FlosyUseCaseBundle:Project')
            ->findByName('My Project')
        ;

        $this->assertCount(1, $projects);
    }
}
