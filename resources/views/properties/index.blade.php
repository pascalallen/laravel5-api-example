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
    <div class="modal-container"></div>
@endsection

@section('script')
    <script type="text/javascript">

    	function book(){
    		// var datastring = $("#reservationForm").serialize();
			$.ajax({
				url: 'api/reservations',
				method: "POST",
				data: {
					first_name: $("input[name=\"first_name\"").val(),
					last_name: $("input[name=\"last_name\"").val(),
					email: $("input[name=\"email\"").val(),
					phone_number: $("input[name=\"phone_number\"").val(),
					start_date: $("input[name=\"start_date\"").val(),
					end_date: $("input[name=\"end_date\"").val(),
					property_id: $("input[name=\"property_id\"").val()
				},
				success: function(result){
					// alert('You\'re all set! Here\'s the scoop: '+result.name+' Check in: '+result.start_date+' Check out: '+result.end_date+' '+result.address+' '+result.city+' '+result.state+' '+result.zipcode);
					console.log(result);
				}
			});
    	};

    	$('input[name="daterange"]').daterangepicker({
			    locale: {
			      format: 'YYYY-MM-DD'
			    }
			}, 
			function(start, end, label) {
		        $.ajax({
					url: 'api/reservations/find',
					method: "POST",
					data: { 
						from: start.format('YYYY-MM-DD'), 
						to: end.format('YYYY-MM-DD')
					},
					success: function(result){
						console.log(result);
						var date1 = new Date(start.format('MM/DD/YYYY'));
						var date2 = new Date(end.format('MM/DD/YYYY'));
						var timeDiff = Math.abs(date2.getTime() - date1.getTime());
						var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

						$(".properties-container").empty();
						$("#availability-check").empty();
						

						if (result.length > 0) {

							var propertyIds = [];

							$("#availability-check").append('<div class="alert alert-info" role="alert"><strong>Between '+start.format('MM/DD/YYYY')+' and '+end.format('MM/DD/YYYY')+' some properties will be available for '+diffDays+' days.</strong></div>');

						    for (var i = 0; i < result.length; i++) { 

								if (result[i].start_date > start.format('YYYY-MM-DD')) {

									var daysOpen;
									var date1 = new Date(start.format('YYYY-MM-DD'));
									var date2 = new Date(result[i].start_date);
									var timeDiff = Math.abs(date2.getTime() - date1.getTime());
									daysOpen = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
									var daysBefore = "<p>"+daysOpen+" days open from "+start.format('MM/DD/YY')+" and "+result[i].start_date+"</p>";
									propertyIds.push(result[i].property_id);
								}else{
									var daysBefore = "";
								}

								if (end.format('YYYY-MM-DD') > result[i].end_date) {

									var daysOpen;
									var date1 = new Date(result[i].end_date);
									var date2 = new Date(end.format('YYYY-MM-DD'));
									var timeDiff = Math.abs(date2.getTime() - date1.getTime());
									daysOpen = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
									var daysAfter = "<p>"+daysOpen+" days open from "+result[i].end_date+" and "+end.format('MM/DD/YY')+"</p>";
									propertyIds.push(result[i].property_id);
								}else{
									var daysAfter = "";
								}
							}
							$.ajax({
								url: 'api/properties/find-multiple',
								method: "POST",
								data: { ids: propertyIds },
								success: function(data){
									for (var i = 0; i < data.length; i++) {
										$(".modal-container").append("<div class=\"modal\" id=\"exampleModal"+i+"\" tabindex=\"-1\" role=\"dialog\">"+
											"<div class=\"modal-dialog\" role=\"document\">"+
												"<div class=\"modal-content\">"+
													"<div class=\"modal-header\">"+
														"<h5 class=\"modal-title\">Book your reservation!</h5>"+
														"<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">"+
															"<span aria-hidden=\"true\">&times;</span>"+
														"</button>"+
													"</div>"+
													"<div class=\"modal-body\">"+
														"<form id=\"reservationForm\" method=\"POST\" action=\"api/reservations\">"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"First name\" type=\"text\" class=\"form-control\" name=\"first_name\"/>"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"Last name\" type=\"text\" class=\"form-control\" name=\"last_name\"/>"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"Email\" type=\"email\" class=\"form-control\" name=\"email\"/>"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"Phone number\" type=\"text\" class=\"form-control\" name=\"phone_number\"/>"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"Start date\" type=\"date\" class=\"form-control\" name=\"start_date\" />"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input placeholder=\"End date\" type=\"date\" class=\"form-control\" name=\"end_date\" />"+
															"</div>"+
															"<div class=\"form-group\">"+
																"<input type=\"hidden\" name=\"property_id\" id=\"property_id\" value="+data[i].id+">"+
																"<button type=\"submit\" class=\"btn btn-sm btn-primary\">Book it!</button>"+
															"</div>"+
														"</form>"+
													"</div>"+
												"</div>"+
											"</div>"+
										"</div>");
									    $(".properties-container").append(
										"<div class=\"card\" style=\"width: 18rem; margin:25px;\">"+
											"<img class=\"card-img-top\" src=\""+data[i].image+"\" alt=\"Card image cap\">"+
											"<button type=\"button\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModal"+i+"\">Book!</button>"+
											"<div class=\"card-body\">"+
												"<h5 class=\"card-title\">"+data[i].name+"</h5>"+
												"<p class=\"card-text\">"+data[i].description+"</p><hr>"+
												daysBefore+
												daysAfter+
												"<strong class=\"card-text\">"+data[i].address+" "+data[i].city+" "+data[i].state+" "+data[i].zipcode+"</strong><br>"+
											"</div>"+
										"</div>");
									}
								}
							});

						}else{
							$("#availability-check").append('<div class="alert alert-danger" role="alert"><strong>Nothing available :(</strong></div>');
						}
					}
				});
			}
		);

    </script>
@endsection