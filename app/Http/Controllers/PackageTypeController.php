<?php

namespace App\Http\Controllers;

use App\Models\PackageType;
use App\Http\Requests\StorePackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\CacheHelper as CacheHelper;

class PackageTypeController extends Controller
{
    var $pageSize = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:packagetype-list');
        $this->middleware('permission:packagetype-create', ['only' => ['create','store']]);
        $this->middleware('permission:packagetype-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:packagetype-delete', ['only' => ['destroy']]);
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
            $packageTypes = Cache::tags([__CLASS__])->get($cacheKey);
        else:
            $packageTypes = PackageType::latest()->paginate($this->pageSize);
            Cache::tags([__CLASS__])->forever($cacheKey, $packageTypes);
        endif;

        return view('packagetypes.index',compact('packageTypes'))->with('i', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('packagetypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageType  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageType $request)
    {
        PackageType::create($request->all());

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packagetypes.index')->with('success','Package type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackageType  $packagetype
     * @return \Illuminate\Http\Response
     */
    public function show(PackageType $packagetype)
    {
        return view('packagetypes.show', compact('packagetype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackageType  $packagetype
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageType $packagetype)
    {
        return view('packagetypes.edit',compact('packagetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageType  $request
     * @param  \App\Models\PackageType  $packagetype
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackageType $request, PackageType $packagetype)
    {
        $packagetype->update($request->all());

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packagetypes.index')->with('success','Package type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageType  $packagetype
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageType $packagetype)
    {
        $packagetype->delete();

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('packagetypes.index')->with('success','Package type deleted successfully');
    }
}
