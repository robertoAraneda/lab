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
        $container = Container::orderBy('id')->with('state_id')->get();

        return $container;
    }

    public function store(
        Container $container,
        StateController $stateController,
        Request $request)
    {
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->state_id = $request->state_id;
        $container->created_user_id = auth()->id();

        $container->save();

        $container['state_id'] = $stateController->show($container->state_id);

        return $container;
    }

    public function show(
        StateController $stateController,
        $id)
    {
        $container = Container::find($id);
        $container['state_id'] = $stateController->show($container->state_id);

        return $container;
    }

    public function update(
        StateController $stateController,
        Request $request,
        $id)
    {
        $container = Container::find($id);
        $container->abbreviation = $request->abbreviation;
        $container->description = $request->description;
        $container->state_id = $request->state_id;
        $container->updated_user_id = auth()->id();

        $container->save();

        $container['state_id'] = $stateController->show($container->state_id);

        return $container;
    }

    public function destroy($id)
    {
        $container = Container::find($id);
        $container->delete();

        return $container;
    }
}
