@extends('layouts.swinedefault')

@section('title')
  Downloadable Files
@endsection


@section('content')
  <div class="container">
    <h4>Downloadable Files</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
    <table class="striped">
    	<thead>
    		<tr class="green lighten-1">
    			<th class="center">Title</th>
    			<th class="center">Description</th>
    			<th class="center">Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($files as $file)
	    		<tr>
	    			<td class="center">{{ $file->file_title }}</td>
	    			<td>{{ $file->description }}</td>
	    			<td><a href="download/{{ $file->file_name }}" download class="btn green darken-4 tooltipped" data-position="right" data-tooltip="Download file"><i class="fas fa-download"></i></a></td>
	    		</tr>	
	    	@endforeach
    	</tbody>
    </table>
  </div>
@endsection