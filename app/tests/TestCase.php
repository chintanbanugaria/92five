<?php
class TestCase extends Illuminate\Foundation\Testing\TestCase {
    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';
        return require __DIR__.'/../../bootstrap/start.php';
    }

    public function testTrivial()
    {
        $this->assertTrue(true);
    }

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp(); // Don't forget this!

        $this->prepareForTests();
    }

    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Mail::pretend(true);
    }

    public function tearDown()
    {
        parent::TearDown();
        \Mockery::close();
    }
}