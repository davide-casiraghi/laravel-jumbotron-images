<?php

namespace Davidecasiraghi\LaravelJumbotronImages\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;
use DavideCasiraghi\LaravelJumbotronImages\Facades\PhpResponsiveQuote;
use DavideCasiraghi\LaravelJumbotronImages\LaravelJumbotronImagesServiceProvider;

class LaravelQuoteTranslationTest extends TestCase
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
            'author' => 'test author name',
        ]);
        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test text',
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
            'author' => 'test author name',
        ]);

        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test text',
            'locale' => 'en',
        ]);

        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test spanish text',
            'locale' => 'es',
        ]);

        $this->get('jumbotron-images-translation/'.$id.'/es/edit')
            ->assertViewIs('laravel-jumbotron-images::jumbotronImagesTranslations.edit')
            ->assertViewHas('quoteId')
            ->assertViewHas('languageCode')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_store_translation_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'author' => 'test author name',
        ]);

        $data = [
            'quote_id' => $id,
            'language_code' => 'es',
            'text' => 'test translation text',
        ];

        $this
            ->followingRedirects()
            ->post('/jumbotron-images-translation', $data);

        $this->assertDatabaseHas('quote_translations', ['text' => 'test translation text']);
    }

    /** @test */
    public function the_route_destroy_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'author' => 'test author name',
        ]);

        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test text',
            'locale' => 'en',
        ]);

        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test spanish text',
            'locale' => 'es',
        ]);

        $this->delete('jumbotron-images-translation/'.$id)
            ->assertStatus(302);
    }

    /** @test */
    public function the_route_update_can_be_accessed()
    {
        $id = JumbotronImage::insertGetId([
            'author' => 'test author name',
        ]);

        QuoteTranslation::insert([
            'quote_id' => $id,
            'text' => 'test text',
            'locale' => 'en',
        ]);

        $translationId = QuoteTranslation::insertGetId([
            'quote_id' => $id,
            'text' => 'test spanish text',
            'locale' => 'es',
        ]);

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'quote_translation_id' => $translationId,
            'quote_id' => $id,
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
