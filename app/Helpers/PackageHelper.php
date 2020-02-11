<?php

namespace App\Helpers;

use App\Models\PackageType;
use App\Http\Requests\StorePackage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * PackageHelper
 *
 * @author Virendra Jadeja <virendrajadeja84@gmail.com>
 */
class PackageHelper
{
    static function generatePackageTypeCollection(Collection $packageTypes)
    {
        $arr = [];
        foreach ($packageTypes as $pt) :
            $arr[$pt->id] = $pt->name;
        endforeach;

        return $arr;
    }

    static function processThumb(StorePackage $request)
    {
        $inputs = $request->all();
        $thumbUrl = '';
        if($request->hasFile('thumb')) :
            $thumbUrl    = $request->thumb->store('images');
            $image       = $request->file('thumb');
            $filename    = $thumbUrl;
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(300, 250);
            $image_resize->save(public_path($filename));
        endif;
        
        if($thumbUrl !== ''):
            $inputs['thumb'] = $thumbUrl;
        else: 
            $inputs = Arr::except($inputs,['thumb']);
        endif;
        return $inputs;
    }
}