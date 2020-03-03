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
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'containers' => $containers
        ], 200);
    }

    public function store(
        Container $container,
        Request $request
    ) {
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->color = $request->color;
        $container->state_id = $request->state_id;
        $container->created_user_id = auth()->id();

        $container->save();

        $container = Container::whereId($container->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();
        return response()->json([
            'container' => $container
        ], 200);
    }

    public function show(
        StateController $stateController,
        $id
    ) {
        $container = Container::find($id);
        $container['state_id'] = $stateController->show($container->state_id);

        return $container;
    }

    public function update(
        Request $request,
        $id
    ) {
        $container = Container::find($id);
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->color = $request->color;
        $container->state_id = $request->state_id;
        $container->updated_user_id = auth()->id();

        $container->save();

        $container = Container::whereId($container->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'container' => $container
        ], 200);
    }

    public function destroy($id)
    {
        $container = Container::find($id);
        $container->delete();

        return response()->json([
            'container' => $container
        ], 200);
    }
}
