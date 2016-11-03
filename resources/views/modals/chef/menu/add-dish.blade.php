<!-- Modal -->
<div id="addDishModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Dish</h4>
            </div>
            <div class="modal-body">
                <select class="form-control" v-model="dishToAdd">
                    <option value="" selected>Select a dish</option>
                    <option v-for="dish in dishes | filterBy dishFilter" :value="dish">@{{ dish.name }}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click='addDishToMenu()' :disabled='dishToAdd == ""'>Add</button>
            </div>
        </div>

    </div>
</div>