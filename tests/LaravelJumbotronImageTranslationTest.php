<?php

namespace Davidecasiraghi\LaravelJumbotronImages\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;
use DavideCasiraghi\LaravelJumbotronImages\Facades\PhpResponsiveQuote;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImageTranslation;
use DavideCasiraghi\LaravelJumbotronImages\LaravelJumbotronImagesServiceProvider;

class LaravelJumbotronImageTranslationTest extends TestCase
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
            'PhpResponsiveQuote' => PhpResponsiveJumbotronImage::class, // facade called PhpResponsiveQuote and the name of the facade class
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
        ];
    }

    /** @test */
    public function the_route_create_translation_can_be_accessed()
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

        $this->get('jumbotron-images-translation/'.$id.'/es/create')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImagesTranslations.create')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_edit_translation_can_be_accessed()
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

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish ',
            'locale' => 'es',
        ]);

        $this->get('jumbotron-images-translation/'.$id.'/es/edit')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImagesTranslations.edit')
            ->assertViewHas('jumbotronImageTranslationId')
            ->assertViewHas('languageCode')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_store_translation_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'imageFileName.jpg',
            'button_url' => 'test button url',
        ]);

        $data = [
            'jumbotron_image_id' => $id,
            'language_code' => 'es',
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish ',
        ];

        $this
            ->followingRedirects()
            ->post('/jumbotron-images-translation', $data);

        $this->assertDatabaseHas('jumbotron_images', ['image_file_name' => 'imageFileName.jpg']);
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

        JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish ',
            'locale' => 'es',
        ]);

        $this->delete('jumbotron-images-translation/'.$id)
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

        $translationId = JumbotronImageTranslation::insert([
            'jumbotron_image_id' => $id,
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish ',
            'locale' => 'es',
        ]);

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'jumbotron_image_translation_id' => $translationId,
            'jumbotron_image_id' => $id,
            'text' => 'test spanish text updated',
            'language_code' => 'es',
         ]);

        //dd($request);
        /*$this->followingRedirects()
             ->put('jumbotron-images-translation/'.$translationId, [$request, $translationId])->dump();
             //->assertStatus(302);*/

        $this->put('jumbotron-images-translation/'.$translationId, [$request, $translationId])
                  ->assertStatus(302);

        //$this->assertDatabaseHas('quote_translations', ['text' => 'test spanish text updated']);
    }
}
