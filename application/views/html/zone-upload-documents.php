<a href="" class="btn no-clickable a-zone-upload-documents">Загрузить файлы</a>
<div class="hidden div-zone-upload-document">
	<p class="upload-document-status"></p>
	<div data-action="<?=$action;?>" class="div-form-action">
		<div id="dropDocumentZone">
			<p class="dropDocumentZoneText">Для загрузки перетащите файл сюда.</p>
		</div>
		<p id="uploadDocument" class="hidden"><label>Технология drag'n'drop не поддерживается, но мы по-прежнему можете использовать стандартный загрузчик:<br><input type="file"></label></p>
	</div>
	<p id="filereader_doc">File API &amp; FileReader API not supported</p>
	<p id="formdata_doc">XHR2's FormData is not supported</p>
	<p id="progress_doc">XHR2's upload progress isn't supported</p>
	<p><progress class="hidden" id="uploadDocProgress" min="0" max="100" value="0">0</progress></p>
</div>