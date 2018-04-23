@extends('layouts.master')

@section('title')Find :)@endsection

@section('content')
	<div class="row navbar text-center">
	    <div class="col">
	        <a class="lead underline-hover" href="/#about">about</a>
	    </div>
	    <div class="col">
	        <a class="lead underline-hover" href="/properties">search</a>
	    </div>
	</div>
    <div class="row justify-content-center">
	    <div class="text-center availability-container">
            <h1 class="display-3">Availability</h1>
            <div class="form-group">
                <input type="text" class="form-control" name="daterange" id="daterange"/>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
    	<div class="text-center" id="availability-check"></div>
    </div>
    <div class="row justify-content-center properties-container"></div>
@endsection

@section('script')
    <script type="text/javascript">
    	function book(from, to, id){
    		if (confirm('Are you sure you want to book this location?')) {
    			 $.ajax({
					url: 'api/properties/'+id,
					method: "PUT",
					data: { 
						start_date: from, 
						end_date: to
					},
					success: function(result){
						alert('You\'re all set! Here\'s the scoop: '+result.name+' Check in: '+result.start_date+' Check out: '+result.end_date+' '+result.address+' '+result.city+' '+result.state+' '+result.zipcode);
					}
				});
    		}
    	};
    	$('input[name="daterange"]').daterangepicker({
			    locale: {
			      format: 'YYYY-MM-DD'
			    }
			}, 
			function(start, end, label) {
		        $.ajax({
					url: 'api/properties/find',
					method: "POST",
					data: { 
						from: start.format('YYYY-MM-DD'), 
						to: end.format('YYYY-MM-DD')
					},
					success: function(result){
						var date1 = new Date(start.format('MM/DD/YYYY'));
						var date2 = new Date(end.format('MM/DD/YYYY'));
						var timeDiff = Math.abs(date2.getTime() - date1.getTime());
						var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
						$("#availability-check").empty();
						if (result.length > 0) {
							$("#availability-check").append('<div class="alert alert-info" role="alert"><strong>Between '+start.format('MM/DD/YYYY')+' and '+end.format('MM/DD/YYYY')+' some properties will be available for '+diffDays+' days.</strong></div>');
						    for (var i = 0; i < result.length; i++) { 
							    $(".properties-container").append(
								"<div class=\"card\" style=\"width: 18rem; margin:25px;\">"+
									"<img class=\"card-img-top\" src=\""+result[i].image+"\" alt=\"Card image cap\">"+
									"<div class=\"card-body\">"+
										"<h5 class=\"card-title\">"+result[i].name+"</h5>"+
										"<p class=\"card-text\">"+result[i].description+"</p><hr>"+
										"<strong class=\"card-text\">"+result[i].address+" "+result[i].city+" "+result[i].state+" "+result[i].zipcode+"</strong>"+
										"<br><br><button type=\"button\" class=\"btn btn-primary\" onclick=\"book('"+start.format('YYYY-MM-DD')+"', '"+end.format('YYYY-MM-DD')+"', '"+result[i].id+"')\">Book me!</button>"+
									"</div>"+
								"</div>");
							}
						}else{
							$("#availability-check").append('<div class="alert alert-danger" role="alert"><strong>Nothing available :(</strong></div>');
						}
					}
				});
			}
		);

    </script>
@endsection