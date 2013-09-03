/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */


var uploadDataDocument = uploadDataDocument || {};
uploadDataDocument.interval = {};
uploadDataDocument.TotalSize = 0;
uploadDataDocument.CurrentSize = {};
uploadDataDocument.FilesSize = {};
uploadDataDocument.maxFileSize = 5000000;
uploadDataDocument.DropZoneDefaultState = function(){
	$("div.div-zone-upload-document").addClass('hidden');
	$("a.a-zone-upload-documents").removeClass('hidden');
}
var dropDocumentZone = document.getElementById("dropDocumentZone");
var doc_tests = {filereader: typeof FileReader != 'undefined',dnd: 'draggable' in document.createElement('span'),formdata: !!window.FormData,progress: "upload" in new XMLHttpRequest};
var doc_support = {filereader: document.getElementById('filereader_doc'),formdata: document.getElementById('formdata_doc'),progress: document.getElementById('progress_doc')};
var acceptedDocTypes = {
	'text/plain': true,
	'application/pdf': true,
	'application/x-zip-compressed': true,
	'application/msword': true,
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document': true,
	'application/vnd.ms-excel': true,
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': true,
	'application/vnd.ms-powerpoint': true,
	'application/vnd.openxmlformats-officedocument.presentationml.presentation': true,
};
var doc_progress = document.getElementById('uploadDocProgress');
var fileupload = document.getElementById('uploadDocument');

"filereader formdata progress".split(' ').forEach(function(api){
	if(doc_tests[api] === false){
		doc_support[api].className = 'fail';
	}else{
		doc_support[api].className = 'hidden';
	}
});

function ReadDocument(files){
	var formData = doc_tests.formdata ? new FormData() : null;
	if(doc_tests.formdata){
		for(var i=0;i<files.length;i++){
			fileIndex = files[i].name.replace(/([ ])/,'_');
			uploadDataDocument.CurrentSize[fileIndex] = 0;
			uploadDataDocument.FilesSize[fileIndex] = files[i].size;
		}
		for(var i=0;i<files.length;i++){
			if(files[i].size <= uploadDataDocument.maxFileSize){
				if(acceptedDocTypes[files[i].type] === true){
					if(doc_tests.formdata) formData.append('file',files[i]);
					UploadDocument(formData,files[i]);
				}else{
					$(dropDocumentZone).after('<div class="msg-alert error">Файл: '+files[i].name+' не загружен.<br/> Формат файла не поддерживается </div>');
				}
			}else{
				$(dropDocumentZone).after('<div class="msg-alert error">Файл: '+files[i].name+' не загружен.<br/> Размер загружаемого файла должен быть не более 2 Мб </div>');
			}
		}
	}
}
function UploadDocument(formData,file){
	var action = $(dropDocumentZone).parents("div.div-form-action").attr('data-action');
	var xhr = new XMLHttpRequest();
	xhr.open('POST',action);
	xhr.fileInfo = file;
	if(doc_tests.progress){
		xhr.upload.onprogress = function(event){
			if(event.lengthComputable){
				var fileIndex = xhr.fileInfo.name.replace(/([ ])/,'_');
				uploadDataDocument.CurrentSize[fileIndex] = event.loaded;
				if(uploadDataDocument.CurrentSize[fileIndex] > uploadDataDocument.FilesSize[fileIndex]){
					uploadDataDocument.CurrentSize[fileIndex] = uploadDataDocument.FilesSize[fileIndex];
				}
			}
		};
	}
	xhr.onload = function(event){
		if(event.target.readyState == 4){
			if(event.target.status == 200){
				var response = $.parseJSON(event.target.responseText);
				if(response.status == true){
					$("<li></li>").appendTo("ul.resources-documents").html(response.responsePhotoSrc);
					$("ul.resources-documents").find("a.delete-resource-item:last").off('click').on("click",function(event){
						event.preventDefault();
						mt.deleteResource(this);
					});
				}else{
					$(dropDocumentZone).after('<div class="msg-alert error">'+response.responseText+'</div>');
				}
				var fileIndex = xhr.fileInfo.name.replace(/([ ])/,'_');
				uploadDataDocument.CurrentSize[fileIndex] = xhr.fileInfo.size;
				doc_progress.value = doc_progress.innerHTML = 100;
			}else{
				doc_progress.className = "hidden";
				doc_progress.innerHTML = 0;
				dropDocumentZone.innerHTML = 'Произошла ошибка!';
				dropDocumentZone.className ='failUpload';
			}
		}
	};
	xhr.setRequestHeader('X-FILE-NAME',xhr.fileInfo.name);
	xhr.send(formData);
}
function getTotalSize(files){
	var total = 0;
	for(var i=0,f;f=files[i];i++){
		if(f.size <= uploadDataDocument.maxFileSize && acceptedDocTypes[f.type] === true){
			total += f.size;
		}
	}
	return total;
}
function uploadDocumentProgress(){
	var loaded = 0;
	$.each(uploadDataDocument.CurrentSize,function(i,val){
		loaded += val;
	});
	if(loaded == uploadDataDocument.TotalSize){
		clearInterval(uploadDataDocument.interval);
		setTimeout(function(){
			doc_progress.className = "hidden";
			doc_progress.innerHTML = 0;
			dropDocumentZone.className = '';
			dropDocumentZone.innerHTML = 'Для загрузки, перетащите файл сюда';
		},1000);
	}else{
		var percent = parseInt((loaded/uploadDataDocument.TotalSize)*100|0);
		doc_progress.value = doc_progress.innerHTML = percent;
	}
}
if(doc_tests.dnd){
	dropDocumentZone.ondragover = function(){this.className = 'hover'; return false;};
	dropDocumentZone.ondragleave = function (){this.className = ''; return false;};
	dropDocumentZone.ondrop = function(event){
		event.stopPropagation();
		event.preventDefault();
		$("div.msg-alert").remove();
		this.className = 'hidden';
		doc_progress.className = "";
		doc_progress.innerHTML = 0;
		uploadDataDocument.interval = setInterval(uploadDocumentProgress,100);
		var files = event.target.files || event.dataTransfer.files;
		uploadDataDocument.TotalSize = getTotalSize(files);
		uploadDataDocument.CurrentSize = {};
		ReadDocument(files);
	}
}else{
	fileupload.className = 'hidden';
	fileupload.querySelector('input').onchange = function(){
		ReadDocument(this.files);
	};
}
$(function(){
	$("a.a-zone-upload-documents").click(function(){
		$(this).addClass('hidden');
		$("div.div-zone-upload-document").removeClass('hidden');
	})
	$("a.delete-documents-item").click(function(){
		mt.deleteResource(this);
	});
});