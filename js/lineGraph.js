$(document).ready(function(){
	$.ajax({
		url : "http://localhost/bgp_webportal/includes/__recentData.php",
		type : "GET",
		success : function(data){
			console.log(data);

			var time_stamp = [];
			var total_prefixes = [];
			var c_isolated = [];
			var c_up = [];
      var c_down = [];
      var c_crossed = [];

			for(var i in data) {
				time_stamp.push(data[i].time_stamp);
				total_prefixes.push(data[i].total_prefixes);
				c_isolated.push(data[i].c_isolated);
				c_up.push(data[i].c_up);
        c_down.push(data[i].c_down);
        c_crossed.push(data[i].c_crossed);
			}

			var chartdata = {
				labels: time_stamp,
				datasets: [
					{
						label: "total_prefixes",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(129, 69, 152, 0.75)",
						borderColor: "rgba(129, 69, 152, 1)",
						pointHoverBackgroundColor: "rgba(129, 69, 152, 1)",
						pointHoverBorderColor: "rgba(129, 69, 152, 1)",
						data: total_prefixes
					},
					{
						label: "c_isolated",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(35, 250, 255, 0.75)",
						borderColor: "rgba(35, 250, 255, 1)",
						pointHoverBackgroundColor: "rgba(35, 250, 255, 1)",
						pointHoverBorderColor: "rgba(35, 250, 255, 1)",
						data: c_isolated
					},
					{
						label: "c_up",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(211, 72, 54, 0.75)",
						borderColor: "rgba(211, 72, 54, 1)",
						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
						data: c_up
					},
          				{
						label: "c_down",
						fill: false,
            					lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: c_down
					},
          				{
						label: "c_crossed",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: c_crossed
					}
				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {

		}
	});
});
