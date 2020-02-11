<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageType;
use App\Http\Requests\StorePackage;
use App\Helpers\PackageHelper;
use App\Helpers\CacheHelper;
use Illuminate\Support\Facades\Cache;

class PackageController extends Controller
{
    var $pageSize = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:package-list');
        $this->middleware('permission:package-create', ['only' => ['create','store']]);
        $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = (request()->input('page', 1) - 1) * $this->pageSize;
        $cacheKey = CacheHelper::getKey(__CLASS__, __FUNCTION__, $page);
        
        if (Cache::has($cacheKey)):
            $packages = Cache::tags([__CLASS__])->get($cacheKey);
        else:
            $packages = Package::latest()->paginate($this->pageSize);
            Cache::tags([__CLASS__])->forever($cacheKey, $packages);
        endif;

        return view('packages.index', compact('packages'))->with('i', $page);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cacheKey = CacheHelper::getKey(__CLASS__, __FUNCTION__);

        if (Cache::has($cacheKey)):
            $ptypes = Cache::tags([__CLASS__, 'ptypes'])->get($cacheKey);
        else:
            $ptypes = PackageHelper::generatePackageTypeCollection(PackageType::all());
            Cache::tags([__CLASS__, 'ptypes'])->forever($cacheKey, $ptypes);
        endif;

        return view('packages.create', compact('ptypes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackage $request)
    {
        $inputs = PackageHelper::processThumb($request);

        Package::create($inputs);

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packages.index')->with('success','Package created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $ptypes = PackageHelper::generatePackageTypeCollection(PackageType::all());

        return view('packages.edit', compact('package','ptypes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePackage  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackage $request, Package $package)
    {
        $inputs = PackageHelper::processThumb($request);
        
        $package->update($inputs);

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packages.index')->with('success','Package updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packages.index')->with('success','Package deleted successfully');
    }

}
