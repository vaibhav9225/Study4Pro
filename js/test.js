window.onload = function(){

	var min=59;
	var sec=60;
	
	$('#disclaimerModal').modal('show');
	var set = setInterval(function(){
	if(min>=0){
	sec--;
		if(sec==0){
			min--;
			sec=60;
			if(min != -1)
				$('#timer').html(min+' Minutes Remaining');
			else
				$('#timer').html('0 Minutes Remaining');
		}
		else{
			$('#timer').html(min+' Minutes '+sec+' Seconds Remaining');
		}
	}
	else{
		if(min==-1){
			$('#timer').html('0 Minutes Remaining');
			$('#alertModal').modal('show');
			clearInterval(set);
		}
	}
	},1000);
	
	$('#alertModal').on('hidden',function(){
		$('#submit').trigger('click');
	});
	
	$('#submit').click(function(){
		if(!$('#submit').hasClass('disabled')){
			var result = new Array();
			for(var i=1; i<=50; i++){
				var ans = $('#question_'+i).attr('rel');
				if($('#option' + ans + '_' + i).attr('checked') == 'checked'){
					result[result.length] = true;
					$('#right_' + i).show();
					$('#optRight' + ans + '_' + i).show();
				}
				else{
					$('#wrong_' + i).show();
					$('#optRight' + ans + '_' + i).show();
					for(var j=1; j<5; j++){
						if($('#option'+j+'_'+i).attr('checked')=='checked'){
							$('#optWrong' + j + '_' + i).show();
							break;
						}
					}
				}
			}
			var marks = result.length;
			if(marks >= 25){
				var grade='You have passed the test.';
			}
			else{
				var grade='You have failed in the test.';
			}
			$('#resultBody').html(grade + '<br/>You have scored a total of ' + marks + ' marks.');
			$('#resultModal').modal('show');
			clearInterval(set);
			$('#submit').addClass('disabled');
		}
	});	
}