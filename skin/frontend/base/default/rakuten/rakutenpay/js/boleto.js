/**
 ************************************************************************
 * Copyright [2017] [RakutenPay]
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
function validateBoletoForm(save) {
    //Clears the div and adds the required RakutenPay method to the form
    var container = document.getElementById("rakutenpay-billet-method-div");
    while (container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
    var rpay_method = document.createElement("input");
    rpay_method.type = "hidden";
    rpay_method.setAttribute("data-rkp", "method");
    rpay_method.value = "billet";
    container.appendChild(rpay_method);

    //Gets the form element
    var form = rpay_method.form;

    //Generates the fingerprint and token
    var rpay = new RPay();
    rpay.listeners = {
        "result:success": function(){
            //Hides the fingerprint and token fields (don't know why it isn't by default)
            document.getElementsByName('rkp[fingerprint]')[0].type = "hidden";
            document.getElementsByName('rkp[fingerprint]')[0].id = "payment[fingerprint]";
            document.getElementsByName('rkp[fingerprint]')[0].name = "payment[fingerprint]";
            save();
        },
        "result:error":   function(errors){
            console.log(errors);
        }
    };
    rpay.generate(form);

  if (validateDocument(document.querySelector('#bilitDocument'))) {
    return true;
  }

  return false;
}
