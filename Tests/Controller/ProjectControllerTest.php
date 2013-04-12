<?php

namespace Flosy\Bundle\UseCaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/project/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('views.project.index.createnew')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('views.common.actions.create')->form(array(
            'flosy_bundle_usecasebundle_projecttype[name]'  => 'My project',
            'flosy_bundle_usecasebundle_projecttype[description]'  => 'Project description.',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertTrue($crawler->filter('span:contains("My project")')->count() > 0);

        // Return to list
        $crawler = $client->click($crawler->selectLink('views.common.actions.back_to_list')->link());
        
        // Edit the entity
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("My project")')->count() > 0);
        $crawler = $client->click($crawler->selectLink('views.common.actions.edit')->link());

        $form = $crawler->selectButton('views.common.actions.update')->form(array(
            'flosy_bundle_usecasebundle_projecttype[name]'  => 'My project updated',
        ), 'PUT');
        
        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="My project updated"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('views.common.actions.delete')->form(array(), 'DELETE'));
        
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/My project updated/', $client->getResponse()->getContent());
    }

}