<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('test')}}" id="adyen-encrypted-form">
                    <input type="text" size="20" autocomplete="" data-encrypted-name="number" />
                    <input type="text" size="20" autocomplete="" data-encrypted-name="holderName" />
                    <input type="text" size="2" maxlength="2" autocomplete="" data-encrypted-name="expiryMonth" />
                    <input type="text" size="4" maxlength="4" autocomplete="" data-encrypted-name="expiryYear" />
                    <input type="text" size="4" maxlength="4" autocomplete="" data-encrypted-name="cvc" />
                    <input type="hidden" value="generate-this-server-side" data-encrypted-name="generationtime" />
                    <input type="submit" value="Pay" />
                </form>
                <span>5100 0811 1222 3332</span><br>
                <span>NOM</span><br>
                <span>08</span><br>
                <span>2018</span><br>
                <span>737</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>