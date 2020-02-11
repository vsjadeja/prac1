<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermission;
use Illuminate\Support\Facades\Cache;
use App\Helpers\CacheHelper as CacheHelper;
use Illuminate\Support\Arr;

class PermissionController extends Controller
{
    var $pageSize = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permission-list');
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
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
            $permissions = Cache::tags([__CLASS__])->get($cacheKey);
        else:
            $permissions = Permission::latest()->paginate($this->pageSize);
            Cache::tags([__CLASS__])->forever($cacheKey, $permissions);
        endif;

        return view('permissions.index',compact('permissions'))->with('i', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StorePermission  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request)
    {
        Permission::create(Arr::except($request->all(),['q']));

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('permissions.index')->with('success','Permission type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StorePermission  $request
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermission $request, Permission $permission)
    {
        $permission->update(Arr::except($request->all(),['q']));

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('permissions.index')->with('success','Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        Cache::tags(__CLASS__)->flush();

        return redirect()->route('permissions.index')->with('success','Permission deleted successfully');
    }
}
