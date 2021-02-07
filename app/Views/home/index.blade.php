@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" title="Github user">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
