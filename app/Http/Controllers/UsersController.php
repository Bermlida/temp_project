<?php

namespace App\Http\Controllers;

use Validator;
use Request;
//use Illuminate\Http\Request;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;

use common;
use user;

class UsersController extends Controller
{

    protected $user_service;

    public function __construct(UserService $user_service)
    {
        /*
        print common::hello_worlds("123456");
        print ((new common("22345678"))->hello_worlds()->assss_world(" do do do A------SSSSSSSS!!!")->result);
        print ((new common(null, ["hello_worlds" => "22345678"]))->assss_world(" do do do A------SSSSSSSS!!!")->result);
        print ((new common("22345678"))->assss_world(" do do do A------SSSSSSSS!!!")->result);
        print ((new common("22345678", ["hello_world" => "32345678"]))->assss_world(" do do do A------SSSSSSSS!!!")->result);
        */
        //user::test();
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
