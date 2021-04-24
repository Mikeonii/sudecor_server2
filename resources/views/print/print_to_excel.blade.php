<div>
	<h1>Sudecor Attendance Report</h1>
	<h3>from:{{$query_info}}</h3>
	<br>
	<br>
	@foreach($full_info as $individual_info)

		<h3>Name: {{$individual_info[0][0]->name}}</h3>	
		<table>
			<thead>
				<tr>
					<th>Time in</th>
					<th>Time out</th>
					<th>Regular Hours</th>
					<th>Over Time</th>
					<th>Sunday</th>
					<th>Holiday</th>
					<th>Night Premium</th>
				</tr>
			</thead>
			<tbody>
				@foreach($individual_info[0][1] as $info)
					<tr>
						<td>{{$info->time_in}}</td>
						<td>{{$info->time_out}}</td>
						<td>{{$info->regular_hour}}</td>
						<td>{{$info->over_time}}</td>
						<td>{{$info->sunday}}</td>
						<td>{{$info->holiday}}</td>
						<td>{{$info->night_premium}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
			
		<h4>Regular Hour: {{$individual_info[0][2][0]}}</h4>
		<h4>Over Time: {{$individual_info[0][2][1]}}</h4>
		<h4>Sunday: {{$individual_info[0][2][2]}}</h4>
		<h4>Holiday: {{$individual_info[0][2][3]}}</h4>
		<h4>Night Premium: {{$individual_info[0][2][4]}}</h4>
		<h4>Cola: {{$individual_info[0][2][5]}}</h4>
		<br>
		<br>
	@endforeach
	
</div>


<style type="text/css">
	div{
		font-family: sans-serif;
	}
	table tr td{
		border:solid;
	}
</style>