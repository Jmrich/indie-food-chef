<div :id="'dish-modal-' + menu.id + '-' + dish.id" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@{{ dish.name }}</h4>
            </div>
            <div class="modal-body">
                <template v-if="hasCutoffTimePassed(menu)">
                    <div class="alert alert-danger">
                        <strong>Oh No! The cutoff time has passed</strong>
                    </div>
                </template>
                <p>@{{ dish.description }}</p>
            </div>
            <template v-if="! hasCutoffTimePassed(menu)">
                <div class="row dish-modal-row">
                    <div class="col-sm-12">
                        <label>Quantity</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="number" min="1" max="99" v-model="menus[menu_index].dishes[dish_index].quantity" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row dish-modal-row">
                    <div class="col-sm-12">
                        <label>Notes</label>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <textarea type="text" class="form-control" placeholder="Notes" v-model="menus[menu_index].dishes[dish_index].notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div class="modal-footer">
                <template v-if="hasCutoffTimePassed(menu)">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </template>
                <template v-else>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" @click='addItemToBag(dish,kitchen)'>Add To Bag</button>
                </template>
            </div>
        </div>

    </div>
</div>