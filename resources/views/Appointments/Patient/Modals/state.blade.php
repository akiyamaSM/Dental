<div class="modal fade" id="myStateModal" tabindex="-1" role="dialog" aria-labelledby="myStateModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    <span>@{{ state.title  }}</span>
                </h4>
            </div>
            <div class="modal-body">
                <span>@{{ state.message }}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-@{{ state.color }} btn-fill" @click.prevent="dispatchAction()">@{{ state.action }}</button>
            </div>
        </div>
    </div>
</div>