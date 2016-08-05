@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <!-- You are logged in! -->                        
                            <div class="col-md-10">
                                <label for="name" class="control-label">Name</label> : 
                                {{ $user->name }}
                            </div>
                            <br>
                            <div class="col-md-10">
                                <label for="email" class="control-label">E-mail</label> : 
                                {{ $user->email }}
                            </div>
                            <br>
                            <div class="col-md-10">                                
                                <label for="api_token" class="control-label">API Token</label> : 
                                {{ $user->api_token}}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
