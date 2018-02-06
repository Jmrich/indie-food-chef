@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-8 col-md-offset-2">
        <div class="panel-heading">
            <h3 class="panel-title">New Dish</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" placeholder="Dish Name">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="description" cols="50" rows="5" placeholder="Dish Description"></textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="price" placeholder="Dish Price">
                        <span class="help-block">
                            <strong>Note: You do not need to include the dollar sign ($)</strong>
                        </span>
                        @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Dish Image</label>
                    <div class="col-sm-6">
                        <input type="file" name="image" id="image">
                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                        <a href="{{ route('dishes.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection