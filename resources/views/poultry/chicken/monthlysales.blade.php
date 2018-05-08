@extends('layouts.newLayout')

@section('title')
  Monthly Sales
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Monthly Sales</h4>
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              {{-- Get date when action performed --}}

              {{-- <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m12 l12">
                        <select>
                          <option value="" disabled selected>Select Month</option>
                          <option value="January">January</option>
                          <option value="February">February</option>
                          <option value="March">March</option>
                          <option value="April">April</option>
                          <option value="May">May</option>
                          <option value="June">June</option>
                          <option value="July">July</option>
                          <option value="August">August</option>
                          <option value="September">September</option>
                          <option value="October">October</option>
                          <option value="November">November</option>
                          <option value="December">December</option>
                        </select>
                        <label>Month</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div> --}}
              {{-- Table for all the replacement stocks to be culled or sold --}}
              <div class="row">
                <div class="col s12 m12 l12">
                  <table class="responsive-table highlight bordered highlight">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Generation</th>
                      <th>Line</th>
                      <th>Family</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                    <tbody>
                      <tr>
                        <td>QUEBAI-F21-231421</td>
                        <td>1</td>
                        <td>2</td>
                        <td>B</td>
                        <td>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#culled-modal">remove_shopping_cart</i></a>
                          </div>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#sold-modal">attach_money</i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>QUEBAI-M11-231421</td>
                        <td>1</td>
                        <td>1</td>
                        <td>A</td>
                        <td>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#culled-modal">remove_shopping_cart</i></a>
                          </div>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#sold-modal">attach_money</i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>QUEBAI-F12-111421</td>
                        <td>1</td>
                        <td>1</td>
                        <td>C</td>
                        <td>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#culled-modal">remove_shopping_cart</i></a>
                          </div>
                          <div class="col s12 m6 l6">
                            <a href="#!"><i class="material-icons modal-trigger" href="#sold-modal">attach_money</i></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="culled-modal" class="modal modal-fixed-footer">
    {!! Form::open([ 'method' => 'post']) !!}
      <div class="modal-content">
        <div class="row">
          <div class="col s12 m12 l12">
            Are you sure you want to mark this entry as culled?
            <div class="row">
              <div class="input-field col s12 m12 l12">
                <textarea id="input_culled" class="materialize-textarea" name="culled_remarks"></textarea>
                <label for="input_culled">Remarks</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="submit">Submit</button>
      </div>
    {!!Form::close()!!}
  </div>
  <div id="sold-modal" class="modal modal-fixed-footer">
    {!! Form::open([ 'method' => 'post']) !!}
      <div class="modal-content">
        <div class="row">
          <div class="col s12 m12 l12">
            Are you sure you want to mark this entry as sold?
            <div class="row">
              <div class="input-field col s12 m12 l12">
                <textarea id="input_sold" class="materialize-textarea" name="sold_remarks"></textarea>
                <label for="input_sold">Remarks</label>
                {{-- <input placeholder="Reason for selling this entry" id="sell_input" type="text" class="validate">
                <label for="sell_input">Remarks</label> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="submit">Submit</button>
      </div>
    {!!Form::close()!!}
  </div>
@endsection

@section('scripts')

@endsection
