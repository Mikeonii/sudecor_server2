<div>
	@foreach($full_info as $individual_info)
		<h1>Name: {{$individual_info[0][0]->name}}</h1>
		
		
		<table>
			<thead>
				<tr>
					<th>Time in</th>
					<th>Time out</th>
				</tr>
			</thead>
			<tbody>
				@foreach($individual_info[0][1] as $info)
					<tr>
						<td>{{$info->time_in}}</td>
						<td>{{$info->time_out}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
			
		<h3>Regular Hour: {{$individual_info[0][2][0]}}</h3>
		<h3>Over Time: {{$individual_info[0][2][1]}}</h3>
		<h3>Sunday: {{$individual_info[0][2][2]}}</h3>
		<h3>Holiday: {{$individual_info[0][2][3]}}</h3>
		
	@endforeach
</div>


<style type="text/css">
	div{
		font-family: sans-serif;
	}
</style>