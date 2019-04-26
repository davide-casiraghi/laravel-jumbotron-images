<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImageTranslation;

class JumbotronImageTranslationController
{
    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $jumbotronImageTranslationId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function create($jumbotronImageTranslationId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-jumbotron-images::jumbotronImagesTranslations.create')
                ->with('jumbotronImageTranslationId', $jumbotronImageTranslationId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $jumbotronImageTranslationId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function edit($jumbotronImageTranslationId, $languageCode)
    {
        $jumbotronImageTranslation = JumbotronImageTranslation::where('jumbotron_image_id', $jumbotronImageTranslationId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-jumbotron-images::jumbotronImagesTranslations.edit', compact('jumbotronImageTranslation'))
                    ->with('jumbotronImageTranslationId', $jumbotronImageTranslationId)
                    ->with('languageCode', $languageCode)
                    ->with('selectedLocaleName', $selectedLocaleName);
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

        // Validate form datas
        $validator = Validator::make($request->all(), [
                'text' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $jumbotronImageTranslation = new JumbotronImageTranslation();

        $this->saveOnDb($request, $jumbotronImageTranslation);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jumbotronImageTranslationId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jumbotronImageTranslationId)
    {
        request()->validate([
            'text' => 'required',
        ]);

        $jumbotronImageTranslation = JumbotronImageTranslation::find($jumbotronImageTranslationId);

        $this->saveOnDb($request, $jumbotronImageTranslation);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImageTranslation  $jumbotronImageTranslation
     * @return void
     */
    public function saveOnDb($request, $jumbotronImageTranslation)
    {
        $jumbotronImageTranslation->jumbotron_image_id = $request->get('jumbotron_image_id');
        $jumbotronImageTranslation->locale = $request->get('language_code');

        $jumbotronImageTranslation->title = $request->get('title');
        $jumbotronImageTranslation->body = $request->get('body');
        $jumbotronImageTranslation->button_text = $request->get('button_text');

        $jumbotronImageTranslation->save();
    }

    /***************************************************************************/

    /**
     * Get the language name from language code.
     *
     * @param  string $languageCode
     * @return string
     */
    public function getSelectedLocaleName($languageCode)
    {
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        $ret = $countriesAvailableForTranslations[$languageCode]['name'];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $jumbotronImageTranslationId
     */
    public function destroy($jumbotronImageTranslationId)
    {
        $jumbotronImageTranslation = JumbotronImageTranslation::find($jumbotronImageTranslationId);
        $jumbotronImageTranslation->delete();

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation deleted succesfully');
    }
}
