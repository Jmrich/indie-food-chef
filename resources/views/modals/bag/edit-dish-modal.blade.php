<div id="edit-item" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Item - @{{ editingItem.name }}</h4>
            </div>
            <div class="modal-body">
                <p>@{{ editingItem.description }}</p>
            </div>
            <div class="row dish-modal-row">
                <div class="col-sm-12">
                    <label>Quantity</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" min="1" max="99" v-model="editingItem.quantity" class="form-control"/>
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
                                <textarea type="text" class="form-control" placeholder="Notes" v-model="editingItem.notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click='updateItem'>Update</button>
            </div>
        </div>

    </div>
</div>