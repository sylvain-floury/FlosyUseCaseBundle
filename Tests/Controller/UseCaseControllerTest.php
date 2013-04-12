<?php

namespace Flosy\Bundle\UseCaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UseCaseControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/usecase/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('views.usecase.index.createnew')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('views.common.actions.create')->form(array(
            'flosy_bundle_usecasebundle_usecasetype[title]'  => 'Use Case',
            'flosy_bundle_usecasebundle_usecasetype[aim]'  => 'Use Case aim',            
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertTrue($crawler->filter('span:contains("Use Case")')->count() > 0);
        
        // Return to list
        $crawler = $client->click($crawler->selectLink('views.common.actions.back_to_list')->link());

        // Edit the entity
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Use Case")')->count() > 0);
        $crawler = $client->click($crawler->selectLink('views.common.actions.edit')->link());

        $form = $crawler->selectButton('views.common.actions.update')->form(array(
            'flosy_bundle_usecasebundle_usecasetype[title]'  => 'Use Case updated',
        ), 'PUT');

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="Use Case updated"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('views.common.actions.delete')->form(array(), 'DELETE'));
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Use Case updated/', $client->getResponse()->getContent());
    }

}