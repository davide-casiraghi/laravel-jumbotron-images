<?php

namespace Davidecasiraghi\LaravelJumbotronImages\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImageTranslation;
use DavideCasiraghi\LaravelJumbotronImages\LaravelJumbotronImagesServiceProvider;

class LaravelJumbotronImageTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testbench']);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelJumbotronImagesServiceProvider::class,
            \Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'PhpResponsiveJumbotronImage' => PhpResponsiveJumbotronImage::class, // facade called PhpResponsiveQuote and the name of the facade class
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
        ];
    }

    /***************************************************************/

    /** @test */
    public function the_console_command_returns_a_quote()
    {
        $this->withoutMockingConsoleOutput();

        PhpResponsiveJumbotronImage::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn('some joke');

        $this->artisan('jumbotron-images');
        $output = Artisan::output();
        $this->assertSame('some joke'.PHP_EOL, $output);
    }

    /** @test */
    public function it_runs_the_migrations()
    {

        // Shows all the tables in the sqlite DB
        /*$tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");
        $tables = array_map('current',$tables);
        dd($tables);*/

        JumbotronImage::insert([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
        ]);

        $jumbotronImage = JumbotronImage::where('image_file_name', '=', 'test image name')->first();

        $this->assertEquals('test image name', $jumbotronImage->image_file_name);
    }

    /** @test */
    public function the_route_index_can_be_accessed()
    {
        $this->get('jumbotron-images')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImages.index')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_create_can_be_accessed()
    {
        $this->get('jumbotron-images/create')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImages.create')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_destroy_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
        ]);

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $this->delete('jumbotron-images/1')
            ->assertStatus(302);
    }

    /** @test */
    public function the_route_update_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
        ]);

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $request = new \Illuminate\Http\Request();
        $request->replace([
              'title' => 'test title updated',
              'body' => 'test body updated',
          ]);

        $this->put('jumbotron-images/1', [$request, 1])
             ->assertStatus(302);
    }

    /** @test */
    public function the_route_store_can_be_accessed()
    {
        $data = [
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'button_url' => 'test button url',
            'image_file_name' => 'test.jpg',
        ];

        $this
            ->followingRedirects()
            ->post('/jumbotron-images', $data);

        $this->assertDatabaseHas('jumbotron_images', ['image_file_name' => 'test.jpg']);
    }

    /** @test */
    public function the_route_show_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
        ]);

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $this->get('jumbotron-images/1')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImages.show')
            ->assertViewHas('jumbotronImage')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_edit_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
        ]);

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $this->get('jumbotron-images/1/edit')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImages.edit')
            ->assertViewHas('jumbotronImage')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_random_quote_can_be_accessed()
    {
        /*PhpResponsiveJumbotronImage::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn([
                'author' => 'Moshe Feldenkreis',
                'text' => 'Another aspect of erect posture is that it is a biological quality of the human frame and there should be no sensation of any doing, holding, or effort whatsoever.',
            ]);*/

        $this->get('random-quote')
            ->assertViewIs('laravel-jumbotron-images::show-random-quote')
            ->assertStatus(200);
        //->assertViewHas('quoteAuthor')
            //->assertViewHas('quoteText')
    }
}
