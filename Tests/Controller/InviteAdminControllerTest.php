<?php
/**
 * This file is part of BraincraftedUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;

use Braincrafted\Bundle\TestingBundle\Test\WebTestCase;

/**
 * InviteControllerTest
 *
 * @category   FunctionalTest
 * @package    BraincraftedUserAdminBundle
 * @subpackage Controller
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      functional
 */
class InviteAdminControllerTest extends WebTestCase
{
    public function setUp()
    {
        // $this->setUpKernel();
    }

    public function tearDown()
    {
        // $this->tearDownKernel();
    }

    /**
     * Tests `listAction()`.
     *
     * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController
     */
    public function testListAction()
    {
        $this->markTestIncomplete('Need to add AppKernel before this test can run.');
    }

    /**
     * Tests `createAction()`.
     *
     * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController
     */
    public function testCreateAction()
    {
        $this->markTestIncomplete('Need to add AppKernel before this test can run.');
    }

    /**
     * Tests `batchCreateAction()`.
     *
     * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController
     */
    public function testBatchCreateAction()
    {
        $this->markTestIncomplete('Need to add AppKernel before this test can run.');
    }

    /**
     * Tests `sendAction()`.
     *
     * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController
     */
    public function testSendAction()
    {
        $this->markTestIncomplete('Need to add AppKernel before this test can run.');
    }

    /**
     * Tests `deleteAction()`.
     *
     * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController
     */
    public function testDeleteAction()
    {
        $this->markTestIncomplete('Need to add AppKernel before this test can run.');
    }

    // /**
    //  * @covers Braincrafted\Bundle\UserAdminBundle\Controller\InviteController::listAction()
    //  */
    // public function testList()
    // {
    //     $client = $this->createClient();
    //     $this->login($client);

    //     $client->followRedirects();
    //     $crawler = $client->request('GET', '/invite');
    //     $this->assertGreaterThan(0, $crawler->filter('h1:contains("Invites")')->count());
    // }

    // /**
    //  * Login.
    //  *
    //  * @param Client $client The client
    //  *
    //  * @return void
    //  */
    // protected function login(Client $client)
    // {
    //     $crawler = $client->request('GET', '/login');
    //     $button = $crawler->selectButton('_submit');
    //     $form = $button->form(array(
    //         '_username' => 'admin',
    //         '_password' => 'admin'
    //     ));
    //     $client->submit($form);
    // }
}
