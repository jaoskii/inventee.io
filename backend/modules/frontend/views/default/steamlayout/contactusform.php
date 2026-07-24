<div class="page-title">
            <h2>Contact Us</h2>
          </div>
          <div class="static-contain">
            <fieldset class="group-select">
              <ul>
                <li id="billing-new-address-form">
                  <fieldset>
                    <legend>New Address</legend>
                    <input type="hidden" name="billing[address_id]" value="" id="billing:address_id">
                    <ul>
                      <li>
                        <div class="customer-name">
                          <div class="input-box name-firstname">
                            <label for="billing:firstname"> First Name<span class="required">*</span></label>
                            <br>
                            <input type="text" id="billing:firstname" name="billing[firstname]" value="" title="First Name" class="input-text ">
                          </div>
                          <div class="input-box name-lastname">
                            <label for="billing:lastname"> Email Address <span class="required">*</span> </label>
                            <br>
                            <input type="text" id="billing:lastname" name="billing[lastname]" value="" title="Last Name" class="input-text">
                          </div>
                        </div>
                      </li>
                      <li>
                        <label for="billing:street1">Subject <span class="required">*</span></label>
                        <br>
                        <input type="text" title="Street Address" name="billing[street][]" id="billing:street1" value="" class="input-text required-entry">
                      </li>

                      <li class="">
                        <label for="comment">Message<em class="required">*</em></label>
                        <br>
                        <div class="">
                          <textarea name="comment" id="comment" title="Comment" class="required-entry input-text" cols="5" rows="3"></textarea>
                        </div>
                      </li>
                    </ul>
                  </fieldset>
                </li>
                <li>
                <p class="require"><em class="required">* </em>Required Fields</p>
                <input type="text" name="hideit" id="hideit" value="">
                <div class="buttons-set">
                  <button type="submit" title="Submit" class="button submit"> <span> Submit </span> </button>
                </div>
                </li>
              </ul>
            </fieldset>
          </div>