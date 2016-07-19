<?php

namespace App\Http\Controllers;

use Validator;
use Request;
//use Illuminate\Http\Request;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Models\Repositories\UserRepository;
//use function App\Models\Helpers\hello_world;
use App\Models\Helpers\Helper;

class UsersController extends Controller
{

    protected $user_service;

    public function __construct(UserService $user_service)
    {
        //print Helper::hello_world('oh~~~~');
        //print (new Helper('mamamama', ['assss_world' => 'AhAhAhCheee']))->hello_world()->assss_world('test')->result;
        //print (new Helper())->hello_world('NaNaNa')->assss_world('test')->result;
        $this->user_service = $user_service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $callback = Request::input("callback");
        $result = $this->user_service->showUserList();
        
        return response()
                        ->json((array)$result, 200)
                        ->setCallback($callback);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_repository = new UserRepository();
        print "<pre>" . \App\Providers\RouteServiceProvider::class . '<br>';
        var_dump($user_repository->user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $callback = $request->input("callback");
        $result = $this->user_service->addUser($data);

        return response()
                        ->json((array)$result, 201)
                        ->setCallback($callback);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $callback = Request::input('callback');
        $result = $this->user_service->showUser($id)->toArray();

        return response()
                        ->json($result, ($result['flag'] ? 200 : 404))
                        ->setCallback($callback);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $callback = $request->input("callback");
        $result = $this->user_service->updateUser($data, $id)->toArray();

        return response()
                        ->json($result, ($result['flag'] ? 200 : 404))
                        ->setCallback($callback);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->user_service->deleteUser($id)->toArray();
        return response()->json($result, ($result['flag'] ? 200 : 404));
    }


    public function test_custum()
    {
        //
    }
}
