<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Para cada teste ele primeiro executará esse método antes de execitar o método do teste.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh --seed');
//        $this->withHeaders(['X-Access-Token' => '']);
    }

    /**
     * Após executar o teste será executado esse método.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
