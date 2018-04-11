<?php

namespace App\Tests;

use App\DataFixtures\TrophyFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Comment;
use App\Entity\TrophyUnlock;
use App\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testUnauthorized()
    {
        $client = $this->makeClient();
        $client->request('GET', '/create');
        $this->assertStatusCode(302, $client);
    }

    public function testPostComment()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $references = $this->loadFixtures([
            UserFixtures::class,
            TrophyFixtures::class
        ])->getReferenceRepository();
        /** @var User $user */
        $user = $references->getReference('user');

        $this->loginAs($user, 'main');
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/create');
        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Comment')->form();
        $form->setValues([
            'app_comment[content]' => 'Hello World!'
        ]);
        $client->enableProfiler();
        $client->submit($form);
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertStatusCode(200, $client);

        $this->assertCount(1, $em->getRepository(Comment::class)->findAll());

        $this->assertCount(1, $em->getRepository(TrophyUnlock::class)->findAll());

        $this->assertEquals(1, $mailCollector->getMessageCount());
    }
}