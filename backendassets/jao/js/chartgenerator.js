function chartGenerator(chartcanvasid,charttype,...chartproperties){
	this.chartcanvas = chartcanvasid;
	this.charttype = charttype;
	this.chartproperties = chartproperties;
}//End function

chartGenerator.prototype = {
	constructor: chartGenerator,
	initialize: function(){
		switch(this.charttype){
			case 'line':
				this.createLineGraph();
			break;

			case 'pie':
				//to follow
			break;
		}//end switch
	},//end fnc
	createLineGraph: function(){
		var salesChartCanvas = $(this.chartcanvas).get(0).getContext('2d');
		var salesChart = new Chart(salesChartCanvas);
		var chartlabels = this.chartproperties[0].chartlabels;
		var chartdata = this.chartproperties[0].chartdata;

		var salesChartData = {
		   labels  : chartlabels,
		   datasets: chartdata
		};
						 
	  	var lineChartDefaultSettings = {
	    // Boolean - If we should show the scale at all
	    showScale               : true,
	    // Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines      : true,
	    // String - Colour of the grid lines
	    scaleGridLineColor      : 'rgba(0,0,0,.05)',
	    // Number - Width of the grid lines
	    scaleGridLineWidth      : 1,
	    // Boolean - Whether to show horizontal lines (except X axis)
	    scaleShowHorizontalLines: true,
	    // Boolean - Whether to show vertical lines (except Y axis)
	    scaleShowVerticalLines  : true,
	    // Boolean - Whether the line is curved between points
	    bezierCurve             : true,
	    // Number - Tension of the bezier curve between points
	    bezierCurveTension      : 0.3,
	    // Boolean - Whether to show a dot for each point
	    pointDot                : true,
	    // Number - Radius of each point dot in pixels
	    pointDotRadius          : 3,
	    // Number - Pixel width of point dot stroke
	    pointDotStrokeWidth     : 1,
	    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	    pointHitDetectionRadius : 20,
	    // Boolean - Whether to show a stroke for datasets
	    datasetStroke           : true,
	    // Number - Pixel width of dataset stroke
	    datasetStrokeWidth      : 2,
	    // Boolean - Whether to fill the dataset with a color
	    datasetFill             : false,
	    // String - A legend template
	    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
	    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio     : true,
	    // Boolean - whether to make the chart responsive to window resizing
	    responsive              : true
	  	};

		// Create the line chart
		salesChart.Line(salesChartData, lineChartDefaultSettings);
	},//end fnc
}//end combooptionloader prototype