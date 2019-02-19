@extends('layouts.swinedefault')

@section('title')
  Cumulative Performance Report
@endsection


@section('content')
  <div class="container">
    <h4>Cumulative Performance Report</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
      <div class="row center">
        <div id="year_cumulative_report" class="col s4 offset-s4">
          {!! Form::open(['route' => 'farm.pig.filter_cumulative_report', 'method' => 'post', 'id' => 'cumulative_report_filter']) !!}
          <select id="year_cumulative_report" name="year_cumulative_report" class="browser-default" onchange="document.getElementById('cumulative_report_filter').submit();">
            <option disabled selected>Year ({{ $filter }})</option>
            @foreach($years as $year)
              <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
          </select>
          {!! Form::close() !!}
        </div>
      </div>
      <div style="overflow-x: auto;">
        <table>
          <thead>
            <tr>
              <th rowspan="2">Parameters</th>
              <th class="center" colspan="{{ count($headings) }}">Months</th>
              <th class="center" rowspan="2">Average &plusmn; SD</th>
            </tr>
            <tr>
              @foreach($headings as $heading)
                <th class="center">{{ $heading }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Litter-size Born Alive</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Number Male Born</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Number Female Born</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Number Stillborn</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Number Mummified</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Litter Birth Weight, kg</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Average Birth Weight, kg</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Litter Weaning Weight, kg</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Average Weaning Weight, kg</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Adjusted Weaning Weight at 45 Days, kg</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Number Weaned</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Age Weaned, days</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
            <tr>
              <td>Pre-weaning Mortality, %</td>
              @foreach($headings as $heading)
                <td class="center"></td>
              @endforeach
              <td class="center">&plusmn;</td>
            </tr>
          </tbody>
        </table>
      </div>
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