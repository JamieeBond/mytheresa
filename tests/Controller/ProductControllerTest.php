<?php

namespace App\Tests\Controller;

use App\Controller\ProductController;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @see ProductController::index()
     * @return void
     */
    public function testIndexNoFilter(): void
    {
        $this->client->request('GET', '/products');
        $expected = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(
            5,
            $expected,
            'Filter not applied, returns all products.'
        );
    }

    /**
     * @see ProductController::index()
     * @return void
     */
    public function testIndexCategoryFilter(): void
    {
        $this->client->request('GET', '/products?category=boots');
        $expected = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(
            3,
            $expected,
            'Filter category:boots, returns 3 products.'
        );
    }

    /**
     * @see ProductController::index()
     * @return void
     */
    public function testIndexPriceLessThanFilter(): void
    {
        $this->client->request('GET', '/products?priceLessThan=80000');
        $expected = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(
            3,
            $expected,
            'Filter priceLessThan:80000, returns 3 products.'
        );
    }

    /**
     * @see ProductController::index()
     * @return void
     */
    public function testIndexAllFilter(): void
    {
        $this->client->request('GET', '/products?category=boots&priceLessThan=80000');
        $expected = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(
            1,
            $expected,
            'Filter category:boots & priceLessThan:80000, returns 1 products.'
        );
    }

    /**
     * @see ProductController::index()
     * @return void
     */
    public function testIndexFilterNoMatch(): void
    {
        $this->client->request('GET', '/products?category=hoodies&priceLessThan=100');
        $expected = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(
            0,
            $expected,
            'Filter category:hoodies & priceLessThan:100, returns 0 products.'
        );
    }
}
