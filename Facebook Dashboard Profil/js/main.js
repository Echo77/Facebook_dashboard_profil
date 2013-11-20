/**
 * @author Constance Laborie
 */


/*
 * TEST PIE CHARTS
 * 
 */
$(document).ready(function(){ 
	 $('#filters select').change(function () {
	   if($( "#filters select" ).val()=="gender")
	   {
	   	gender();
	   }
	   else if($( "#filters select" ).val()=="top")
	   {
	   	top_like();
	   
	   }   
	   else
	   {
	   		alert("coucou");
	   } 
	    })
	
});


function gender()
	{
	$(function () {
	    var chart;
	    $(document).ready(function() {
	        var options = {    
	        		chart: {
	                renderTo: 'target',
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false,
	                type: 'pie'
	            },
	            title: {
	                text: '% gender'
	            },
	            tooltip: {
	        	    pointFormat: '{point.percentage}%</b>',
	            	percentageDecimals: 1
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    dataLabels: {
	                        enabled: true,
	                        color: '#000000',
	                        connectorColor: '#000000',
	                       formatter: function() {
	                            return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
	                        }
	                    }
	                }
	            },
	            series: [{
	               data :[]
	            }]
	            }
	            
	    		var params = {
	       					 action: 'gender'
	   						 };
	   			$.ajax({
			        url: '../../../licornou/php/fblicornephp/stats.php',
			        type: 'POST', 
			        data: params,
			        cache: false,
			       dataType: 'json',

			        success: function(res) {
			        	//alert($.parseJSON(res));
			        	options.series[0].data = res;
			        	//points = [{"name":"play","data":[3]},{"name":"pause","data":[10]}]
			        	//options.series[0].data = points;
			        	//options.series[1].data = points;
	   					// options.series = points;
	   					
	   					// $("#target").append(res.friends.data[0].gender);
	   		
						
			        	//alert(res);
			           // options.series = res;
			          
			            chart = new Highcharts.Chart(options);
	        									}
	   				 });
	        
	    });
	    
	});
	}
function top_like()
	{
		$(function () {
	    var chart;
	    $(document).ready(function() {
	         var options = {
	            chart: {
	                renderTo: 'target',
	                type: 'column'
	            },
	            title: {
	                text: 'Top like'
	            },
	            subtitle: {
	                text: 'Tout types de statut'
	            },
	            xAxis: {
	                categories: [
	                    'Nom'                    
	                ]
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Nombre de like'
	                }
	            },
	         /*   legend: {
	                layout: 'vertical',
	                backgroundColor: '#FFFFFF',
	                align: 'left',
	                verticalAlign: 'top',
	                x: 300,
	                y: 70,
	                floating: true,
	                shadow: true
	            },*/
	            tooltip: {
	                formatter: function() {
	                    return ''+
	                        this.series.name + ': <b>'+ this.y+' fois</b>';
	                }
	            },
	            plotOptions: {
	                column: {
	                    pointPadding: 0.2,
	                    borderWidth: 0,
	                    dataLabels: {
	                        enabled: true,
	                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'grey'
	                    			}
	               			 }
	                
	           				 },
	           				 
	                series: [{
	    
	            }]
	            
	            }
	    		var params = {
	       					 action: 'top'
	   						 };
	   			$.ajax({
			        url: '../../../licornou/php/fblicornephp/stats.php',
			        type: 'POST',
			        data: params,
			        cache: false,
			        dataType: 'json',
			        success: function(points) {
	   					options.series = points;
			            chart = new Highcharts.Chart(options);
	        									}
	   				 });
	        });
	     
	    });
	    
	}
