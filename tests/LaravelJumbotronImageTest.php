<?php

namespace Davidecasiraghi\LaravelJumbotronImages\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\DB;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;
use DavideCasiraghi\LaravelJumbotronImages\Facades\LaravelJumbotronImages;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImageTranslation;
use DavideCasiraghi\LaravelJumbotronImages\LaravelJumbotronImagesServiceProvider;

use DavideCasiraghi\LaravelJumbotronImages\Http\Controllers\JumbotronImageController;
use Illuminate\Support\Facades\Storage;

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
    public function the_facade_can_be_reached()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test.jpg',
            'button_url' => 'test button url',
        ]);

        $jumbotronImage = LaravelJumbotronImages::getJumbotronImage(1);
        $this->assertStringContainsString($jumbotronImage->image_file_name, 'test.jpg');

        //$jumbotronImage = LaravelJumbotronImages::showJumbotronImage(1);
        //$jumbotronImage->assertViewIs('laravel-jumbotron-images::show-jumbotron-image')
        //->assertViewHas('jumbotronImage')
        //$jumbotronImage->assertStatus(200);

        //$this->assertStringContainsString($jumbotronImage->image_file_name, 'test title');
    }

    /** @test */
    public function it_returns_parameters_array()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test.jpg',
            'button_url' => 'http://www.google.it',
            'button_color' => 'press-teal',
            'jumbotron_height' => 'is-fullheight',
            'cover_opacity' => '0.3',
            'scroll_down_arrow' => 1,
            'parallax' => 1,
            'white_moon' => 1,
            'text_width' => '80',
            'text_vertical_alignment' => 'align-items: center;',
            'text_horizontal_alignment' => '1',
            'text_shadow' => 1,
        ]);

        $jumbotronImage = JumbotronImage::find($id);
        $parameters = LaravelJumbotronImages::getParametersArray($jumbotronImage);
        $this->assertStringContainsString($parameters['text_horizontal_alignment'], 'text-align: center;');
    }

    /** @test */
    public function it_shows_a_jumbotron_image()
    {
        $id = JumbotronImage::insertGetId([
            'image_file_name' => 'test.jpg',
            'button_url' => 'http://www.google.it',
            'button_color' => 'press-teal',
            'jumbotron_height' => 'is-fullheight',
            'cover_opacity' => '0.3',
            'scroll_down_arrow' => 1,
            'parallax' => 1,
            'white_moon' => 1,
            'text_width' => '80',
            'text_vertical_alignment' => 'align-items: center;',
            'text_horizontal_alignment' => '1',
            'text_shadow' => 1,
        ]);

        $jumbotronImageView = LaravelJumbotronImages::showJumbotronImage($id);
        //dd($jumbotronImageView->jumbotronImage->text_vertical_alignment);
        $this->assertStringContainsString($jumbotronImageView->jumbotronImage->text_vertical_alignment, 'align-items: center;');
    }
    
    /** @test */
    public function it_uploads_an_image()
    {
        // Fake any disk here
        Storage::fake('public');
        
        // Symulate the upload
            $local_test_file = __DIR__ . '/test-files/large-avatar.png';
            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $local_test_file,
                'large-avatar.png',
                'image/png',
                null,
                null,
                true
            );
            //dd($uploadedFile);
        
        // Call the function uploadImageOnServer()
            $imageFile = $uploadedFile;
            $imageName = $imageFile->hashName();
            $imageSubdir = 'jumbotron_images';
            $imageWidth = '1067';
            $thumbWidth = '690';

            JumbotronImageController::uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
        
    
        //$filePath = 'app/public/images/jumbotron_images/'.$imageName;
        $filePath = '/app/public/images/jumbotron_images/'.$imageName;
    
        Storage::disk('public')->assertExists($filePath);
        
        
    }
}
