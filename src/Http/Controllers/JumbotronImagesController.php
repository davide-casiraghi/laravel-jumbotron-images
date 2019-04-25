<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelJumbotronImages\Facades\LaravelJumbotronImagesFacade;

class JumbotronImagesController
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
            $jumbotronImages = JumbotronImage::orderBy('author')
                                     ->where('author', 'like', '%'.$request->input('keywords').'%')
                                     ->paginate(20);
        } else {
            $jumbotronImages = JumbotronImage::orderBy('author')
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
        $jumbotronImage->author = $request->get('author');
        $jumbotronImage->text = $request->get('text');

        // Set the default language to edit the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $jumbotronImage);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Quote added succesfully');
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

        return view('laravel-jumbotron-images::jumbotronImages.show', compact('quote'));
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

        return view('laravel-jumbotron-images::jumbotronImages.edit', compact('quote'));
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
                            ->with('success', 'Quote updated succesfully');
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
                            ->with('success', 'Quote deleted succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\PhpResponsiveRandomQuote\Models\Quote  $jumbotronImage
     * @return void
     */
    public function saveOnDb($request, $jumbotronImage)
    {
        $jumbotronImage->translateOrNew('en')->text = $request->get('text');
        $jumbotronImage->author = $request->get('author');
        $jumbotronImage->save();
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRandomJumbotronImage()
    {
        $jumbotronImage = PhpResponsiveJumbotronImage::getRandomJumbotronImage();

        // the view name is set in the - Service provider - boot - loadViewsFrom
        return view('php-responsive-JumbotronImage::show-random-quote', [
            'quoteAuthor' => $jumbotronImage['author'],
            'quoteText' => $jumbotronImage['text'],
        ]);
    }
}
