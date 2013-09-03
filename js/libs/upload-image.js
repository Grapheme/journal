/* Author: Grapheme Group
* http://grapheme.ru/
*/
var uploadDataObject = uploadDataObject || {};
uploadDataObject.interval = {};
uploadDataObject.CurrentSize = 0;
uploadDataObject.TotalSize = 0;
uploadDataObject.maxFileSize = 1000000;

var uploadZone = $("div.div-select-uploading-image");
var inputFile = $("input.input-select-photo");
var acceptedTypes = {'image/png': true,'image/jpeg': true,'image/gif': true};
var progress = $("#uploadprogress");
var fileupload = $("upload");

function ReadFile(file){
	var formData = new FormData();
	if(file.size <= uploadDataObject.maxFileSize && acceptedTypes[file.type] === true){
		formData.append('file',file);
		UploadFile(formData,file);
	}else{
		$(progress).addClass('hidden').html(0);
		$(uploadZone).removeClass('hidden').after('<div class="msg-alert error">Размер более 1Мб</div>');
	}
}
function UploadFile(formData,file){
	var action = $(inputFile).attr('data-action');
	var xhr = new XMLHttpRequest();
	xhr.open('POST',action);
	xhr.fileInfo = file;
	xhr.upload.onprogress = function(event){
			if(event.lengthComputable){
				uploadDataObject.CurrentSize = event.loaded;
			}
		};
	xhr.onload = function(event){
		if(event.target.readyState == 4){
			if(event.target.status == 200){
				uploadDataObject.CurrentSize = xhr.fileInfo.size;
				$(progress).val(100).html(0);
				var response = $.parseJSON(event.target.responseText);
				if(response.status == true){
					$("img.destination-photo").attr('src',response.responsePhotoSrc);
					$("a.a-select-uploading-image").html('Изменить фотографию');
					if($("a.a-remove-user-avatar").exists() == true && $("a.a-remove-user-avatar").hasClass('hidden')){
						$("a.a-remove-user-avatar").removeClass('hidden');
					}
				}else{
					$(progress).addClass('hidden').html(0);
					$(uploadZone).removeClass('hidden').after('<div class="msg-alert error">'+response.responseText+'</div>');
				}
			}else{
				$(progress).addClass('hidden').html(0);
			}
		}
	};
	xhr.setRequestHeader('X-FILE-NAME',xhr.fileInfo.name);
	xhr.send(formData);
}
function uploadProgress(){
	if(uploadDataObject.CurrentSize == uploadDataObject.TotalSize){
		clearInterval(uploadDataObject.interval);
		setTimeout(function(){
			$(progress).addClass('hidden').html(0);
			$(uploadZone).removeClass('hidden');
		},1000);
	}else{
		var percent = parseInt((uploadDataObject.CurrentSize/uploadDataObject.TotalSize)*100|0);
		$(progress).val(percent).html(percent);
	}
}

$(function(){
	$("a.a-select-uploading-image").click(function(){
		if($("div.msg-alert").exists() == true){
			$("div.msg-alert").remove();
		}
		$(this).siblings('input.input-select-photo').click();
	});
	$(inputFile).change(function(event){
		event.stopPropagation();
		event.preventDefault();
		uploadDataObject.interval = setInterval(uploadProgress,500);
		var file = event.target.files[0];
		uploadDataObject.TotalSize = file.size;
		$(uploadZone).addClass('hidden');
		$(progress).removeClass('hidden').html('');
		ReadFile(file);
	});
});