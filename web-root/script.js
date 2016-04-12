/*
* @Author: Nate Bosscher (c) 2015
* @Date:   2016-04-11 12:51:15
* @Last Modified by:   Nate Bosscher
* @Last Modified time: 2016-04-12 13:16:11
*/



$(document).ready(function(){
	var list = [];
	var _photos = [];
	var photosRead = 0;
	var uploadTotalLength;

	$("#item-purchase-date").datepicker({});

	$("#start input").click(function(){
		$("#start").css('display', "none");
		$("#form").css('display', "block");
	});

	function removeListItem(){
		var index = $(this.parentNode).index() - 2;
		list.splice(index, 1);
		renderList();
	}

	function renderList(){
		if(list.length > 0){
			$("#list-no-items").css("display", "none");
		}else{
			$("#list-no-items").css("display", "");
		}

		$(".list-item:not(#list-template)").remove();

		for(var i = 0; i < list.length; i++){
			var tmpl = $("#list-template").clone(false);

			tmpl.attr("id", "");
			tmpl.css("display", "block");
			$(".description", tmpl).html(list[i].description);
			$(".amount", tmpl).html(list[i].amount);
			$("input", tmpl).click(removeListItem);

			$("#form-list").append(tmpl);
		}
	}

	$("#add-submission").click(function(){
		$("#form").css('display', "none");
		$("#item-form").css("display", "block");
	});

	$("#add-upload-item").click(function(){
		$("#item-receipt").click();
	});

	function removePhoto(){
		var index = $(this.parentNode).index();
		_photos.splice(index, 1);
		redrawPhotos();
	}

	function redrawPhotos(){
		var frame = $("#receipt-photos");
		var div;

		// remove old stuff
		frame.empty();

		if(_photos.length == 0)
			$("#receipt-photos").css('display', 'none');
		else
			$("#receipt-photos").css('display', '');

		for(var i = 0; i < _photos.length; i++){
			var dv = $("<li></li>");
			div = $('<div></div>');
			div.html(_photos[i].fname);

			var rm = $('<input type="button" value="remove" />');
			rm.click(removePhoto);

			dv.append(div);
			dv.append(rm);

			frame.append(dv);
		}
	}

	function addPhotoFile(file){
		if(file.size > 1000000){ // 1 mb
			alert("Please use photos smaller than 1Mb");
			return;
		}

		var reader = new FileReader();

		reader.addEventListener("load", function(){
			_photos.push({
				content: reader.result,
				fname: file.name
			});

			photosRead--;
			
			if(photosRead == 0)
				$("#item-receipt").val(""); // clear the field to make way for more items

			redrawPhotos();
		}, false);

		reader.readAsDataURL(file);
	}

	$("#item-receipt").change(function(){
		if(this.files.length > 0){
			photosRead = this.files.length;

			for(var i = 0; i < this.files.length; i++){
				addPhotoFile(this.files[i]);
			}
		}
	});

	$("#add-form-item").click(function(){
		if($("#item-description").val() == "" || 
			$("#item-amount").val() == "" || 
			$("#item-description").val() == "" || 
			$("#item-committee").val() == "" || 
			$("#item-line-item").val() == "" ||
			_photos.length == 0){

			$("#item-missing-fields").css("display", "block");
			return;
		}

		$("#item-missing-fields").css("display", "");

		list.push({
			amount: $("#item-amount").val(),
			description: $("#item-description").val(),
			dateOfPurchase: $("#item-purchase-date").val(),
			committee: $("#item-committee").val(),
			budgetLineItem: $("#item-line-item").val(),
			photos: _photos
		});

		renderList();

		_photos = [];
		redrawPhotos();
		$("#item-amount").val("");
		$("#item-description").val("");
		$("#item-purchase-date").val("");
		$("#item-committee").val("");
		$("#item-line-item").val("");

		$("#form").css('display', "block");
		$("#item-form").css("display", "none");
	});

	$("#cancel-add-form-item").click(function(){
		$("#form").css('display', "block");
		$("#item-form").css("display", "none");
	});

	function submitItem(){
		var data = new FormData();
		var el = list.pop();

		data.append("submitter", $("#submission-submitter").val());
		data.append("dateOfPurchase", el.dateOfPurchase);
		data.append("committee", el.committee);
		data.append("budgetLineItem", el.budgetLineItem);
		data.append("amount", el.amount);
		data.append("description", el.description);


		for(var i in el.photos){
			var str = el.photos[i].content;
			var _type = str.substring(str.indexOf(":")+1,str.indexOf(";"));
			var _content = str.substring(str.indexOf(",")+1);

			var blob = new Blob([_content], {type: _type});
			blob.lastModifiedDate = new Date();

			data.append("file" + i, blob);
			data.append("file" + i + "-type", el.photos[i].fname);
		}

		$.ajax({
			method: "POST",
			cache: false,
			processData: false,
			contentType: false,
			data: data
		}).success(function(data){
			$("#submit-processing p").html("Progress: " + Math.round(list.length / uploadTotalLength * 100) + "%");

			if(data == "1"){
				if(list.length > 0){
					submitItem();
				}else{
					showSubmitSuccess();
				}
			}else{
				showSubmitError();
			}
		}).error(function(data){
			showSubmitError();
		});
	}

	function showSubmitSuccess(){
		$("#submit-processing").css("display", "none");
		$("#form").css("display", "none");
		$("#submit-success").css("display", "block");
	}

	function showSubmitError(){
		$("#form").css("display", "none");
		$("#submit-processing").css("display", "none");
		$("#submit-error").css("display", "block");

		var lst = [];
		for(var i = 0; i < list.length; i++)
			lst.push(list[i].description);

		$("#submit-error-msg").html("There was an error and the following items were not submitted.<br>" + lst.join(",<br>"));
	}

	$("#submit-receipt").click(function(){
		if(list.length == 0){
			$("#items-missing").css("display", "block");
			return;
		}else{
			$("#items-missing").css("display", "none");
		}

		if($("#submission-submitter").val() == ""){
			$("#sumitter-missing").css("display", "block");
			return;
		}else{
			$("#sumitter-missing").css("display", "none");
		}

		uploadTotalLength = list.length;
		$("#submit-processing").css("display", "block");
		submitItem();
	});

	renderList();
	redrawPhotos();

});