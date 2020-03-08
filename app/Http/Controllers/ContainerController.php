<?php

namespace App\Http\Controllers;

use App\Container;
use Illuminate\Http\Request;

class ContainerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.container');
    }

    public function index()
    {
        $containers = Container::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'containers' => $containers
        ], 200);
    }

    public function store(
        Container $container,
        Request $request
    )
    {
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->color = $request->color;
        $container->state_id = $request->state_id;
        $container->created_user_id = auth()->id();

        $container->save();

        $container = $this->show($container->id);

        return response()->json([
            'container' => $container
        ], 200);
    }

    public function show($id
    )
    {
        return Container::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();

    }

    public function update(
        Request $request,
        $id
    )
    {
        $container = Container::whereId($id)->first();
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->color = $request->color;
        $container->state_id = $request->state_id;
        $container->updated_user_id = auth()->id();

        $container->save();

        $container = $this->show($container->id);

        return response()->json([
            'container' => $container
        ], 200);
    }

    public function destroy($id)
    {
        $container = Container::whereId($id)->first();
        $container->delete();

        return response()->json([
            'container' => $container
        ], 200);
    }
}
