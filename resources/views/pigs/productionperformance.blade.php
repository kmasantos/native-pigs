@extends('layouts.swinedefault')

@section('title')
	Production Performance Report
@endsection

@section('content')
	<div class="container">
		<h4>Production Performance Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#persowview">Per sow</a></li>
	        <li class="tab"><a href="#perboarview">Per boar</a></li>
	        <li class="tab"><a href="#perparityview">Per parity</a></li>
	        <li class="tab"><a href="#permonthview">Per month</a></li>
	      </ul>
	    </div>
	    <!-- PER SOW -->
	    <div id="persowview" class="col s12">
	    	{{-- 1. FARROWING INDEX
	    	2. PARITY (LATEST)
	    	3. NUMBER MALE BORN
	    	4. NUMBER FEMALE BORN
	    	5. LITTER BIRTH WEIGHT
	    	6. AVERAGE BIRTH WEIGHT
	    	7. NUMBER STILL BORN
	    	8. NUMBER MUMMIFIED
	    	9. LITTER WEIGHT OF WEANING
	    	10. AVERAGE WEANING WEIGHT
	    	11. ADJUSTED WEANING WEIGHT AT 45 DAYS
	    	12. NUMBER WEANED
	    	13. AGE WEANED
	    	14. PRE-WEANING MORTALITY (NUMBER BORN - NUMBER WEANED) --}}
	    </div>
	    <!-- PER BOAR -->
	    <div id="perboarview" class="col s12">
	    	{{-- 1. FARROWING INDEX
	    	2. PARITY (LATEST)
	    	3. NUMBER MALE BORN
	    	4. NUMBER FEMALE BORN
	    	5. LITTER BIRTH WEIGHT
	    	6. AVERAGE BIRTH WEIGHT
	    	7. NUMBER STILL BORN
	    	8. NUMBER MUMMIFIED
	    	9. LITTER WEIGHT OF WEANING
	    	10. AVERAGE WEANING WEIGHT
	    	11. ADJUSTED WEANING WEIGHT AT 45 DAYS
	    	12. NUMBER WEANED
	    	13. AGE WEANED
	    	14. PRE-WEANING MORTALITY (NUMBER BORN - NUMBER WEANED) --}}
	    </div>
	    <!-- PER PARITY -->
	    <div id="perparityview" class="col s12">
	    </div>
	    <!-- PER MONTH -->
	    <div id="permonthview" class="col s12">
	    </div>
		</div>
	</div>
@endsection