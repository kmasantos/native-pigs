@extends('layouts.swinedefault')

@section('title')
  Cumulative Report
@endsection


@section('content')
  <div class="container">
    <h4>Cumulative Report</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
      <table style="overflow-x: scroll;">
        <thead>
          <tr>
            <th>Parameters</th>
            <th class="center">Month</th>
            <th class="center">Average &plusmn; SD</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Litter-size Born Alive</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Number Male Born</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Number Female Born</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Number Stillborn</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Number Mummified</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Litter Birth Weight, kg</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Average Birth Weight, kg</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Litter Weaning Weight, kg</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Average Weaning Weight, kg</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Adjusted Weaning Weight at 45 Days, kg</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Number Weaned</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Age Weaned, days</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
          <tr>
            <td>Pre-weaning Mortality, %</td>
            <td class="center"></td>
            <td class="center">&plusmn;</td>
          </tr>
        </tbody>
      </table>
    </div>
	</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year,
      today: 'Today',
      clear: 'Clear',
      close: 'Ok',
      closeOnSelect: false, // Close upon selecting a date,
      format: 'yyyy-mm-dd', 
      max: new Date()
    });
  </script>
@endsection