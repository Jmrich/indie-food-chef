@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-8 col-md-offset-2">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $dish->name }}</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('dishes.update', [$dish]) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="{{ $dish->name }}">
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
                        <textarea class="form-control" name="description" cols="50" rows="5">{{ $dish->description }}</textarea>
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
                        <input type="text" class="form-control" name="price" value="{{ $dish->price/100 }}">
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

                {{--<div class="form-group{{ $errors->has('extra_cost') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-3 control-label">Additional Cost</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="extra_cost" value="{{ $dish->extra_cost/100 }}">
                        @if ($errors->has('extra_cost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('extra_cost') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>--}}

                <div class="form-group{{ $errors->has('is_archived') ? ' has-error' : '' }}">
                    <label for="is_archived" class="col-sm-3 control-label">Archived?</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="is_archived">
                            @if($dish->is_archived)
                                <option value="true" selected>Yes</option>
                                <option value="false">No</option>
                            @else
                                <option value="true">Yes</option>
                                <option value="false" selected>No</option>
                            @endif
                        </select>
                        @if ($errors->has('is_archived'))
                            <span class="help-block">
                                <strong>{{ $errors->first('is_archived') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <a href="{{ route('dishes.show', [$dish]) }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection