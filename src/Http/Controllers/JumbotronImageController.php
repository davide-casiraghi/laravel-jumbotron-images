<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;

class JumbotronImageController
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchKeywords = $request->input('keywords');
        //$searchCategory = $request->input('category_id');
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        if ($searchKeywords) {
            $jumbotronImages = JumbotronImage::
                                select('jumbotron_image_translations.jumbotron_image_id AS id', 'title', 'body', 'button_text', 'image_file_name', 'button_url', 'locale')
                                ->join('jumbotron_image_translations', 'jumbotron_images.id', '=', 'jumbotron_image_translations.jumbotron_image_id')
                                ->orderBy('title')
                                ->where('title', 'like', '%'.$searchKeywords.'%')
                                ->where('locale', 'en')
                                ->paginate(20);
        } else {
            $jumbotronImages = JumbotronImage::
                                select('jumbotron_image_translations.jumbotron_image_id AS id', 'title', 'body', 'button_text', 'image_file_name', 'button_url', 'locale')
                                ->join('jumbotron_image_translations', 'jumbotron_images.id', '=', 'jumbotron_image_translations.jumbotron_image_id')
                                ->where('locale', 'en')
                                ->orderBy('title')
                                ->paginate(20);
        }

        return view('laravel-jumbotron-images::jumbotronImages.index', compact('jumbotronImages'))
                             ->with('i', (request()->input('page', 1) - 1) * 20)
                             ->with('searchKeywords', $searchKeywords)
                             ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laravel-jumbotron-images::jumbotronImages.create');
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jumbotronImage = new JumbotronImage();

        // Set the default language to edit the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $jumbotronImage);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image added succesfully');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function show($jumbotronImageId = null)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);

        return view('laravel-jumbotron-images::jumbotronImages.show', compact('jumbotronImage'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function edit($jumbotronImageId = null)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);

        return view('laravel-jumbotron-images::jumbotronImages.edit', compact('jumbotronImage'));
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);

        // Set the default language to update the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $jumbotronImage);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image updated succesfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function destroy($jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);
        $jumbotronImage->delete();

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image deleted succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage  $jumbotronImage
     * @return void
     */
    public function saveOnDb($request, $jumbotronImage)
    {
        $jumbotronImage->translateOrNew('en')->title = $request->get('title');
        $jumbotronImage->translateOrNew('en')->body = $request->get('body');
        $jumbotronImage->translateOrNew('en')->button_text = $request->get('button_text');
        //$jumbotronImage->image_file_name = $request->get('image_file_name');
        $jumbotronImage->button_url = $request->get('button_url');
        
        // Teacher profile picture upload
        if ($request->file('image_file_name')) {
            $imageFile = $request->file('image_file_name');
            $imageName = $imageFile->hashName();
            $imageSubdir = 'teachers_profile';
            $imageWidth = '1067';
            $thumbWidth = '690';

            $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
            $jumbotronImage->image_file_name = $imageName;
        } else {
            $jumbotronImage->image_file_name = $request->image_file_name;
        }

        $jumbotronImage->save();
    }

    /***************************************************************************/
    
    /**
     * Upload image on server.
     *
     * @param  $imageFile - the file to upload
     * @param  $imageName - the file name
     * @param  $imageSubdir - the subdir in /storage/app/public/images/..
     * @return void
     */
    public function uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth)
    {

        // Create dir if not exist (in /storage/app/public/images/..)
        if (! \Storage::disk('public')->has('images/'.$imageSubdir.'/')) {
            \Storage::disk('public')->makeDirectory('images/'.$imageSubdir.'/');
        }

        $destinationPath = 'app/public/images/'.$imageSubdir.'/';

        // Resize the image with Intervention - http://image.intervention.io/api/resize
        // -  resize and store the image to a width of 300 and constrain aspect ratio (auto height)
        // - save file as jpg with medium quality
        $image = \Image::make($imageFile->getRealPath())
                                ->resize($imageWidth, null,
                                    function ($constraint) {
                                        $constraint->aspectRatio();
                                    })
                                ->save(storage_path($destinationPath.$imageName), 75);

        // Create the thumb
        $image->resize($thumbWidth, null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->save(storage_path($destinationPath.'thumb_'.$imageName), 75);
    }

    // **********************************************************************
}
