<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">A payer : @{{ tableauPanier[3]}}</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('verficationPaiement')}}" id="adyen-encrypted-form">
                    <fieldset>
                        <legend>Card Details</legend>
                        <label for="adyen-encrypted-form-number">
                            Card Number
                            <input type="text" class="form-control" id="adyen-encrypted-form-number" value="5555444433331111" size="20" autocomplete="off" data-encrypted-name="number" />
                        </label>
                        <label for="adyen-encrypted-form-holder-name">
                            Card Holder Name
                            <input type="text" class="form-control" id="adyen-encrypted-form-holder-name" value="John Doe" size="20" autocomplete="off" data-encrypted-name="holderName" />
                        </label>
                        <label for="adyen-encrypted-form-cvc">
                            CVC
                            <input type="text"class="form-control"  id="adyen-encrypted-form-cvc" value="737" size="4" autocomplete="off" data-encrypted-name="cvc" />
                        </label>
                        <label for="adyen-encrypted-form-expiry-month">
                            Expiration Month (MM)
                            <input type="text" value="06" class="form-control"   id="adyen-encrypted-form-expiry-month" size="2"  autocomplete="off" data-encrypted-name="expiryMonth" />
                        </label>
                        <label for="adyen-encrypted-form-expiry-year">Expiration Year (YYYY)
                            <input type="text" value="2016" class="form-control" id="adyen-encrypted-form-expiry-year"  size="4"  autocomplete="off" data-encrypted-name="expiryYear" />
                        </label>

                        <input type="hidden" id="adyen-encrypted-form-expiry-generationtime" value="<?=date("c") ?>" data-encrypted-name="generationtime" />
                        <input type="submit"   class="btn btn-success form-control" value="Payer" />
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>