@extends('layouts.app')
@section('content')
	<div >

		<form class="form-inline" action="/restaurant" method="get">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="restaurant_name">restaurant Name</label>
				<input type="text" class="form-control" name="restaurant_name" placeholder="restaurant name">
			</div>

			<div class="form-group">
				<label for="date" class="col-md-2 control-label">Start Date</label>
				<div class="input-group date form_date col-md-9" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
					<input class="form-control" size="16" type="text" value="" readonly name="start_date">
					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<button type="submit" class="btn btn-default">search</button>
		</form>
		<script type="text/javascript">
            $('.form_date').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: 'yyyy-mm-dd'
            });

		</script>
	</div>

	<a class="more-link-custom" href="/restaurant/create"><span><i>NEW POST Restaurant</i></span></a>


		@foreach($restaurants as $restaurant)
		<article class="format-image group">
			<h2 class="post-title pad">
				<a href="/restaurant/{{ $restaurant->id }}"> {{ $restaurant->restaurant_name }}</a>
			</h2>
			<div class="post-inner">
				<div class="post-deco">
					<div class="hex hex-small">
						<div class="hex-inner"><i class="fa"></i></div>
						<div class="corner-1"></div>
						<div class="corner-2"></div>
					</div>
				</div>
				<div class="post-content pad">
					<div class="entry custome">
						{{ $restaurant->content }}
					</div>
					@if ($restaurant->userID == Auth::user()->id)
					<a class="more-link-custom" href="restaurant/{{ $restaurant->id }}/edit/"><span><i>Edit</i></span></a>
					@endif

					@if ($restaurant->userID == Auth::user()->id)
						<form action="restaurant/{{ $restaurant->id }}" method="POST">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" class="btn btn-danger btn-sm center-block">Delete</button>
						</form>
					@endif
				</div>

			</div>
		</article>

		@endforeach

@endsection
