/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

var uploadDataImage = uploadDataImage || {};
uploadDataImage.interval = {};
uploadDataImage.TotalSize = 0;
uploadDataImage.CurrentSize = {};
uploadDataImage.FilesSize = {};
uploadDataImage.maxFileSize = 5000000;
uploadDataImage.DropZoneDefaultState = function(){
	$("div.div-zone-upload-file").addClass('hidden');
	$("a.a-zone-upload-resources").removeClass('hidden');
}
var dropZone = document.getElementById("dropZone");
var tests = {filereader: typeof FileReader != 'undefined',dnd: 'draggable' in document.createElement('span'),formdata: !!window.FormData,progress: "upload" in new XMLHttpRequest};
var support = {filereader: document.getElementById('filereader'),formdata: document.getElementById('formdata'),progress: document.getElementById('progress')};
var acceptedImgTypes = {'image/png': true,'image/jpeg': true,'image/gif': true};
var progress = document.getElementById('uploadimageprogress');
var fileupload = document.getElementById('upload');

"filereader formdata progress".split(' ').forEach(function(api){
	if(tests[api] === false){
		support[api].className = 'fail';
	}else{
		support[api].className = 'hidden';
	}
});

function ReadFiles(files){
	var formData = tests.formdata ? new FormData() : null;
	if(tests.formdata){
		for(var i=0;i<files.length;i++){
			fileIndex = files[i].name.replace(/([ ])/,'_');
			uploadDataImage.CurrentSize[fileIndex] = 0;
			uploadDataImage.FilesSize[fileIndex] = files[i].size;
		}
		for(var i=0;i<files.length;i++){
			if(files[i].size <= uploadDataImage.maxFileSize){
				if(acceptedImgTypes[files[i].type] === true){
					if(tests.formdata) formData.append('file',files[i]);
					UploadFile(formData,files[i]);
				}else{
					$(dropZone).after('<div class="msg-alert error">Файл: '+files[i].name+' не загружен.<br/> Формат файла не поддерживается </div>');
					breakProgress();
				}
			}else{
				$(dropZone).after('<div class="msg-alert error">Файл: '+files[i].name+' не загружен.<br/> Размер загружаемого файла должен быть не более 2 Мб </div>');
				breakProgress();
			}
		}
	}
}
function UploadFile(formData,file){
	var action = $(dropZone).parents("div.div-form-action").attr('data-action');
	var xhr = new XMLHttpRequest();
	xhr.open('POST',action);
	xhr.fileInfo = file;
	if(tests.progress){
		xhr.upload.onprogress = function(event){
			if(event.lengthComputable){
				var fileIndex = xhr.fileInfo.name.replace(/([ ])/,'_');
				uploadDataImage.CurrentSize[fileIndex] = event.loaded;
				if(uploadDataImage.CurrentSize[fileIndex] > uploadDataImage.FilesSize[fileIndex]){
					uploadDataImage.CurrentSize[fileIndex] = uploadDataImage.FilesSize[fileIndex];
				}
			}
		};
	}
	xhr.onload = function(event){
		if(event.target.readyState == 4){
			if(event.target.status == 200){
				var response = $.parseJSON(event.target.responseText);
				if(response.status == true){
					$("<li></li>").appendTo("ul.resources-items").html(response.responsePhotoSrc);
					$("ul.resources-items").find("a.delete-resource-item:last").off('click').on("click",function(event){
						event.preventDefault();
						mt.deleteResource(this);
					});
				}else{
					$(dropZone).after('<div class="msg-alert error">'+response.responseText+'</div>');
				}
				var fileIndex = xhr.fileInfo.name.replace(/([ ])/,'_');
				uploadDataImage.CurrentSize[fileIndex] = xhr.fileInfo.size;
				progress.value = progress.innerHTML = 100;
			}else{
				progress.className = "hidden";
				progress.innerHTML = 0;
				dropZone.innerHTML = 'Произошла ошибка!';
				dropZone.className ='failUpload';
			}
		}
	};
	xhr.setRequestHeader('X-FILE-NAME',xhr.fileInfo.name);
	xhr.send(formData);
}
function getTotalSize(files){
	var total = 0;
	for(var i=0,f;f=files[i];i++){
		if(f.size <= uploadDataImage.maxFileSize && acceptedImgTypes[f.type] === true){
			total += f.size;
		}
	}
	return total;
}
function uploadProgress(){
	var loaded = 0;
	$.each(uploadDataImage.CurrentSize,function(i,val){
		loaded += val;
	});
	if(loaded == uploadDataImage.TotalSize){
		clearInterval(uploadDataImage.interval);
		breakProgress();
	}else{
		var percent = parseInt((loaded/uploadDataImage.TotalSize)*100|0);
		progress.value = progress.innerHTML = percent;
	}
}

function breakProgress(){
	
	setTimeout(function(){
		progress.className = "hidden";
		progress.innerHTML = 0;
		dropZone.className = '';
		dropZone.innerHTML = 'Для загрузки, перетащите файл сюда';
	},1000);
}

if(tests.dnd){
	dropZone.ondragover = function(){this.className = 'hover'; return false;};
	dropZone.ondragleave = function (){this.className = ''; return false;};
	dropZone.ondrop = function(event){
		event.stopPropagation();
		event.preventDefault();
		$("div.msg-alert").remove();
		this.className = 'hidden';
		progress.className = "";
		progress.innerHTML = 0;
		uploadDataImage.interval = setInterval(uploadProgress,100);
		var files = event.target.files || event.dataTransfer.files;
		uploadDataImage.TotalSize = getTotalSize(files);
		uploadDataImage.CurrentSize = {};
		ReadFiles(files);
	}
}else{
	fileupload.className = 'hidden';
	fileupload.querySelector('input').onchange = function(){
		ReadFiles(this.files);
	};
}
$(function(){
	$("a.a-zone-upload-resources").click(function(){
		$(this).addClass('hidden');
		$("div.div-zone-upload-file").removeClass('hidden');
	})
	$("a.delete-resource-item").click(function(){
		mt.deleteResource(this);
	});
});