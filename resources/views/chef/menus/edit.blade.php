@extends('layouts.app')

@section('content')
    <menu-edit
            :user="user"
            :chef="chef"
            :menu="{{ $menu }}"
            :dishes="{{ $dishes }}"
            :sections="{{ $menu->sections }}"
            :dates="{{ $dates }}" inline-template>
        <div>
            <div class="alert alert-success col-md-6 col-md-offset-3" v-if="form.successful">
                Menu successfully updated!
            </div>
            <div class="panel panel-default col-md-6 col-md-offset-3">
                <div class="panel-heading">
                    <ul class="panel-title list-inline">
                        <li>@{{ menu.name }} (Editing)</li>
                        <li>|</li>
                        <li><a href="{{ route('menus.show', [$menu]) }}" class="btn btn-primary btn-sm">Back</a> </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <!-- Add dish modal -->
                        @include('modals.chef.menu.add-dish')
                        <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                            <label class="col-md-3 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" v-model="form.menu.name" :value="menu.name">

                                <span class="help-block" v-show="form.errors.has('name')">
                                    @{{ form.errors.get('name') }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error': form.errors.has('description')}">
                            <label class="col-md-3 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="description" v-model="form.menu.description">@{{ menu.description }}</textarea>

                                <span class="help-block" v-show="form.errors.has('description')">
                                    @{{ form.errors.get('description') }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Active?</label>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" value="0" name="is_active" v-model="form.menu.is_active" :checked="menu.is_active == 0" />No
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="1" name="is_active" v-model="form.menu.is_active" :checked="menu.is_active == 1" />Yes
                                </label>
                            </div>
                        </div>
                        <div class="well">
                            <ul class="list-inline">
                                <li>Dishes</li>
                                <li>|</li>
                                <li><i class="fa fa-plus-circle" aria-hidden="true" data-toggle="modal" data-target="#addDishModal"></i></li>
                            </ul>
                        </div>

                        {{--<template v-for="section in sections">
                            <div class="well">
                                <ul class="list-inline">
                                    <li>@{{ section.name }}</li>
                                    <li>|</li>
                                    <li><i class="fa fa-times-circle" aria-hidden="true" @click='removeSection(section)'></i></li>
                                </ul>
                            </div>

                            <template v-for="dish in section.dishes">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <ul class="list-inline">
                                            <li>@{{ dish.name }}</li>
                                            <li><i class="fa fa-times" aria-hidden="true"></i></li>
                                        </ul>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDishModal">Add Dish</button>
                                    </div>
                                </div>
                            </template>
                        </template>--}}


                        <table class="table">
                            <tr>
                                <th>Name</th>
                                {{--<th>Description</th>--}}
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Starting Quantity</th>
                                <th>Quantity Remaining</th>
                            </tr>
                            <tbody v-for="(key,dish) in form.dishes">
                                <tr>
                                    <td>@{{ dish.name }}</td>
                                    {{--<td class="col-sm-3">@{{ dish.description }}</td>--}}
                                    <td>
                                        <select class="form-control" v-model="form.dishes[key].start_date" id="dates">
                                            <option v-for="date in dates" :value="date" :selected="areDatesEqual(date,dish.pivot.start_date)">@{{ date }}</option>
                                            {{--<option :value="dish.pivot.expires_at">@{{ dish.pivot.expires_at }}</option>--}}
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" v-model="form.dishes[key].end_date" id="dates">
                                            <option v-for="date in dates" :value="date" :selected="areDatesEqual(date,dish.pivot.end_date)">@{{ date }}</option>
                                            {{--<option :value="dish.pivot.expires_at">@{{ dish.pivot.expires_at }}</option>--}}
                                        </select>
                                    </td>
                                    <td class="col-sm-2">
                                        <input type="text" v-model="form.dishes[key].starting_quantity" class="form-control" :value="dish.pivot.starting_quantity">
                                    </td>
                                    <td class="col-sm-2">
                                        <input type="text" v-model="form.dishes[key].quantity_remaining" class="form-control" :value="dish.pivot.quantity_remaining">
                                    </td>
                                    <td>
                                        <i class="fa fa-times" aria-hidden="true" @click='removeDish(dish)'></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{--<div v-for="dish in form.dishes">
                            <div class="form-group">
                                <div class="col-md-3">
                                    @{{ dish.name }}
                                </div>
                                <div class="col-md-3">
                                    @{{ dish.description }}
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control">
                                        <option v-for="date in dates" :value="date" :selected="areDatesEqual(date,dish.pivot.expires_at)">@{{ date }}</option>
                                        --}}{{--<option :value="dish.pivot.expires_at">@{{ dish.pivot.expires_at }}</option>--}}{{--
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-times" aria-hidden="true" @click='removeDish(dish)'></i>
                                </div>
                            </div>

                        </div>--}}
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-3">
                                <button type="button" @click='update'>Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </menu-edit>
@endsection