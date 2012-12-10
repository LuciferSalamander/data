// JavaScript Document
//$.noConflict();
$(document).ready(function() { 
	 $('.login').exists(function() {
         $.fn.getLoginLink();
     });					   
	//preload all our images for faster display
	$('.preload_imgs').exists(function() {
		$(['challenge.png','dataset.png',
		   'dsw_logo.png','dsw_logo_sc.png','dsw_logo_small.png','evidence.png',
		   'gears.gif','icon_bug_1.png','live_rep.png','loading.gif','models.png',
		   'motorcycle_rep.png','partners.png','random.png','solution.png',
		   'static_rep.png','thumb.png','total_disps.png','wazi.png','map.png','snow.png']).preloadImages();
	});
	//call the necessary javascript functions
	$('.snow').exists(function() {
    //  $.fn.snow();//only call when snow element exists
     });
	$('#pie').exists(function() {
       $.fn.charting();//only call when pie element exists
     });
	$('#img1').exists(function() {
      $.fn.imgEffects();//only call when img1 id exists
    });
	$('#hdr').exists(function() {
        $.fn.fixedHeader();//only call when header element exists
    });
	$('#wpts_id').exists(function() {
        $.fn.wpt_id_autocomplete();//only call when wpt_id element exists
    });
	
	$('#issuetypeoptions').exists(function() {
        $.fn.getssueTypes();
    });
	$('#usersoptions').exists(function() {
       $.fn.getusers();
    });
	$('.export_rpt').exists(function() {//shoddy code to export html table to excel
       $("a#exp").click(function(){
			        $('#oaf_report').exists(function() {					
			              $.fn.ToExcel('oaf_report', 'OAF Spotcheck Results');
					 });
					 $('#mph_report').exists(function() {					
			              $.fn.ToExcel('mph_report', 'MPH Spotcheck Results');
					 });
					  $('#moe_report').exists(function() {					
			              $.fn.ToExcel('moe_report', 'MOE Spotcheck Results');
					 });
					  $('#cd_report').exists(function() {					
			              $.fn.ToExcel('cd_report', 'Chlorine Delivery Results');
					 });
					  $('#mc_report').exists(function() {					
			              $.fn.ToExcel('mc_report', 'Motorcycle Records');
					 });
					   $('#pilots').exists(function() {					
			              $.fn.ToExcel('pilots', 'Reference Pilots ');
					 });
		});
    });
	$('#gb').exists(function() {
       $("#gb").click(function(){	
			 if(document.referrer.indexOf(window.location.hostname) != -1){
				parent.history.back();
				return false;
			}
			// $("#link2").trigger('click');	
            
		});
    });
	$('.rep_tbl').exists(function() {								  
		 $('html, body').animate({ scrollTop: $(".repbox").offset().top  }, 2000);//animate scrolling to the description to capture att
		 $("a#rep").click(function(){
			
			$(".repbox").hide(600);
			var toShow = $(this).attr('href');
			$(toShow).show(200);
			 return false;
		});
		
    });
	$('.ds_tbl').exists(function() {								  
		 $('html, body').animate({ scrollTop: $(".repbox").offset().top  }, 2000);//animate scrolling to the description to capture att
		 
		 $("a#ds").click(function(){			
			$(".repbox").hide(600);
			var toShow = $(this).attr('href');
			$(toShow).show(200);
		//	$('html, body').animate({ scrollTop: $(".repbox").offset().top  }, 2000);//animate scrolling to the description to capture att
			 return false;
		});
		 $("a.export_rpt").click(function(){				  
			 
			 
		     $.fn.dlFile($(this).attr('href'));	//pass the relevant parameters
			return false;
		});
		 
		 
		
				
    });
	$(".challenge").middleBoxButton("The Challenge", "http://www.poverty-action.org/safewater/test/challenge");
	$(".solution").middleBoxButton("The Solution", "http://www.poverty-action.org/safewater/test/solution");
	$(".evidence").middleBoxButton("The Evidence", "http://www.poverty-action.org/safewater/test/evidence");
	$(".models").middleBoxButton("Models Used", "http://www.poverty-action.org/safewater/test/models");
	$(".partners").middleBoxButton("Program Partners", "http://www.poverty-action.org/safewater/test/programsandpartners");
	
});
$.fn.middleBoxButton = function(text, url) {
    var $el, $tempDiv, $tempButton, divHeight = 0;
    return this.hover(function(e) {
    
        $el = $(this).css("border-color", "white");
        divHeight = $el.height() + parseInt($el.css("padding-top")) + parseInt($el.css("padding-bottom"));
                
        $tempDiv = $("<div />", {
            "class": "overlay rounded"
        });
                
        $tempButton = $("<a />", {
            "href": url,
            "text": text,
            "class": "widget-button rounded",
            "css": {
                "top": (divHeight / 2) - 7 + "px"
            }
        }).appendTo($tempDiv);
                
        $tempDiv.appendTo($el);
        
    }, function(e) {
    
        $el = $(this).css("border-color", "#999");
    
        $(".overlay").fadeOut("fast", function() {
            $(this).remove();
        })
    
    });
    
}
$.fn.charting=function()
{
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'pie',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: true
		},
		title: {
			text: 'Dispensers Installed As Of Today'
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
			}
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
						return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Dispenser Installation',
			data: [
				['School(MOE)',  11.0],
				['Health Center(MPH)',  Math.round(7,1)],
				{
					name: 'Agricultural Bundling(OAF)',
					y: 60.0,
					sliced: true,
					selected: true
				},
				['Research(WASH,PMI,CFD,Sendhil)',    17.0],
				['Expansion(Tanathi)',     1.0],
				['Local Government(BCC,BMC,LVN,MMC)',   4.0]
			]
		}]
	});
	
}
$.fn.imgEffects=function(){
	 $('#img1').fadeIn().delay(9000).fadeOut(3000);
}
$.fn.fixedHeader=function(){
	    var div = $('#hdr');
        var start = $(div).offset().top;
 
    $.event.add(window, "scroll", function() {
        var top_offset = $(window).scrollTop();
        $(div).css('position',((top_offset)>start) ? 'fixed' : 'static');
        $(div).css('top',((top_offset)>start) ? '0px' : '');

    });
}
$.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);

  if (this.length) {
    callback.call(this, args);
  }

  return this;
}

$.fn.getssueTypes = function()
{	 
	  //change link later to more advance link
	   $.getJSON('http://data.safe-water.org/rest/issues/getissuetypes', function(data) {	//do a json call to get issuetype		
			 var options = $("#issuetypeoptions");
			$.each(data, function() {
				options.append($("<option/>").val(this.issuetypeid).text(this.issuetypename));
			});
		});      
}
$.fn.getusers= function()
{	 
	  //change link later to more advance link	 
       $.getJSON('http://data.safe-water.org/rest/issues/getusers', function(data) {	//do a json call to get users	
			 var options = $("#usersoptions");
			$.each(data, function() {
				options.append($("<option />").val(this.user_id).text(this.username));
			});
		});
}
$.fn.ToExcel = function(table,name)
{
 
  var uri = 'data:application/vnd.ms-excel;base64,';
  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
  
   var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	
  function a(table, name) 
  {
	    
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
  
  return a(table, name);

}
 $.fn.dlFile=function(sc)
 {
	var fileDownloadCheckTimer;
    var token = new Date().getTime(); //use the current timestamp as the token value
  var boxID = $(".repbox").attr('id');
			  $('#' + boxID).append('<iframe id="downloadFrame"></iframe>');//internal frame to download the file
			  $('#' + boxID).append('<br/><br/><div id="dvloader">Please wait, the dataset is being generated<br/><br/><img src="images/gears.gif"/></div>');
		 $.blockUI({ message: $('#dvloader'), 
             css: { 
             border: 'none', 
             padding: '15px',         
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
			'border-radius': '10px',            
            'font-family':'Open Sans Bold',
             color:'#00416A' 
            }  }); 
  
   $("#downloadFrame").attr({ src: sc + "/" + token});//use iframe to download the file

fileDownloadCheckTimer = window.setInterval(function () {
      var cookieValue =$.cookie('fileDownloadToken');//read the cookie
	
	if ($.trim(cookieValue) == $.trim(token))
	  {	
		 $.cookie('fileDownloadToken', null); //clears this cookie value
         $.unblockUI();		
	  }
    }, 1000);
 }
$.fn.preloadImages = function() {
    this.each(function(){
        $('<img/>')[0].src = "images/"+this;
    });
}
$.fn.getLoginLink = function() {
    $.ajax({
            url: 'link.php',
            success: function(response) {
            //   document.write(data);
			  $("a").attr("href", response)
            }
        });
}
