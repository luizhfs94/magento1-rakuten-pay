/**
 ************************************************************************
 * Copyright [2018] [RakutenConnector]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

/**
 * Observer for checkout price modifications, like changes in shipment price or taxes
 * to call the installments value with the updated value
 * @object OnestepcheckoutForm.hidePriceChangeProcess
 *
 */

OnestepcheckoutForm.prototype.hidePriceChangeProcess = OnestepcheckoutForm.prototype.hidePriceChangeProcess.wrap(function(hidePriceChangeProcess){
    var granTotalAmountUpdated = convertPriceStringToFloat(this.granTotalAmount.textContent);

    if (document.getElementById('grand_total') !== null && parseFloat(document.getElementById('grand_total').value) !== granTotalAmountUpdated) {
        document.getElementById('grand_total').value = granTotalAmountUpdated;
        if (document.getElementById('creditCardNumVisible') !== null && document.getElementById('creditCardNumVisible').value.length > 6) {
            getInstallments(document.getElementById('creditCardBrand').value);
        }
    }

    return hidePriceChangeProcess();
});


/**
 * Call events before magento OneSstepChekouPayment switchToMethod event - only call
 * when the type of payment selected is relative to RakutenPay methods, preventing to
 * save all the time a PagSeguro Method is selected
 * @type OnestepcheckoutShipment
 */
OnestepcheckoutShipment.prototype.switchToMethod = OnestepcheckoutShipment.prototype.switchToMethod.wrap(
    function (switchToMethod, methodCode, forced) {
        if (isRakutenPayCurrentPaymentMethod() && forced === true) {
            return false; //do nothing
        }

        // normal flow
        return switchToMethod(methodCode, forced);
    });

OnestepcheckoutForm.prototype.validate = OnestepcheckoutForm.prototype.validate.wrap(function (validate) {
    if (validateRakutenPayActiveMethod(validate)) {
        return validate();
    }
});

/**
 * Validate the active payment method before magento save payment
 * @returns {Boolean}
 */
function validateRakutenPayActiveMethod(save) {
    //OSCPayment.currentMethod
    switch (document.querySelector('#checkout-payment-method-load .radio:checked').value) {
        case "rakutenpay_credit_card":
            console.log("rakutenpay_credit_card");
            return validateCreditCardForm(save);
            break;
        case "rakutenpay_boleto":
            return validateBoletoForm(save);
            break;
        default:
            return true;
            break;
    }
}

/**
 * Converts an brazilian real price string, like R$9,99, or 9,99, to float (9.99)
 * @param {string} priceString
 * @returns {float}
 */
function convertPriceStringToFloat(priceString){
    if(priceString === ""){
        priceString =  0;
    }else{
        priceString = priceString.replace("R$","");
        priceString = priceString.replace(".","");
        priceString = priceString.replace(",",".");
        priceString = parseFloat(priceString);
    }
    return priceString;
}

/**
 * Return if is selected an RakutenPay Payment Method as a current payment method
 * in the checkout payment section
 * @returns {bolean}
 */
function isRakutenPayCurrentPaymentMethod() {
    currentPaymentMethod = document.querySelector('input[name="payment[method]"]:checked').value;
    return (currentPaymentMethod === 'rakutenpay_credit_card' || currentPaymentMethod === 'rakutenpay_boleto');
}