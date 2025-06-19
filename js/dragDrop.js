let dropzone = document.querySelector('.dropzone');
let uploadIcon = document.querySelector('.upload-icon');
let fileUpload = document.querySelector('#file-upload');
formData = new FormData();

// calling the function for setting file uploader input field size
setFileInputSize();

// event listener for window resize
window.addEventListener('resize', function(event){
    setFileInputSize();
});

// function for setting file uploader input field size
function setFileInputSize(){
    let dropzoneHeight = dropzone.offsetHeight;
    let dropzoneWidth = dropzone.offsetWidth;
    fileUpload.style.height = dropzoneHeight+'px';
    fileUpload.style.width = dropzoneWidth+'px';
}

dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    uploadIcon.setAttribute('src', 'resources/images/upload_cloud.svg');
    uploadIcon.style.transform = 'scale(1)';
    upload(e.dataTransfer.files);
});

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
    uploadIcon.setAttribute('src', 'resources/images/upload_cloud_gray.svg');
    uploadIcon.style.transform = 'scale(1.5)';
    return false;
});

dropzone.addEventListener('dragleave', (e) => {
   dropzone.classList.remove('dragover');
    uploadIcon.setAttribute('src', 'resources/images/upload_cloud.svg');
    uploadIcon.style.transform = 'scale(1)';
   return false;
});


function upload(files){
    $('.file-input')[0].files = files;
    uploadIcon.style.display='none';
    $('.table-container').css("display", "block"), $(".tool-nav-container").css("display", "block"), $(".tool-content-title")[0].innerText = "Upload",  $('.instruction-text').css('display', 'none');
    $('#file-upload').css("z-index", -1);
    createTable();
     updateTable();
}

function createTable() {
    // formData = new FormData;
    for (let e = 0; e < $("#file-upload").prop("files").length; e++) formData.append("files[]", $("#file-upload").prop("files")[e])
}

function updateTable() {
    const e = ["srt", "vtt", "stl", "sbv", "sub", "ass"];
    let t = 0;
    const n = formData.getAll("files[]").length;
    let o = !1;
    $("tbody").html("");
    for (let n = 0; n < formData.getAll("files[]").length; n++) {
        let l = [];
        const i = formData.getAll("files[]")[n];
        l.extension = i.name.split(".").pop(), l.name = i.name.replace(/C:\\fakepath\\/i, "").replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9 ]/g, " "), l.size = Math.trunc(i.size / Math.pow(1e3, 1)), t += l.size, e.includes(l.extension) ? $("tbody").append('<tr>                        <td><img src="resources/images/checked.svg"></td>                        <td>' + l.name + "</td>                        <td>" + l.size + " KB</td>                        <td>." + l.extension + '</td>                        <td><button class="delete">' + n + "<button</td>               </tr>") : (showError(3, "There are one or more invalid files!"), o = !0, $("tbody").append("<tr style='border: solid 2px #B00020'>                        <td><img src=\"resources/images/error.svg\"></td>                        <td>" + l.name + "</td>                        <td>" + l.size + " KB</td>                        <td>." + l.extension + '</td>                        <td><button class="delete">' + n + "<button</td>               </tr>"))
    }
    t > 1e3 ? ($("#files_info_size").css("color", "#B00020"), showError(1, "You have exceeded the maximum allowed size!"), o = !0) : ($("#files_info_size").css("color", "#616161"), hideError(1)), o || hideError(3), n > 20 ? ($("#files_info_amount").css("color", "#B00020"), showError(2, "You have exceeded the maximum number of files allowed"), o = !0) : ($("#files_info_amount").css("color", "#616161"), hideError(2)), $("#files_amount").text(n), $("#files_size").text(t), o ? $("#next-button").prop("disabled", !0) : 0 === document.getElementsByTagName("tbody")[0].childNodes.length ? $("#next-button").prop("disabled", !0) : $("#next-button").prop("disabled", !1)
}

$("#next-button").click(function() {
    document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", $.ajax({
        url: "upload_file.php",
        data: formData,
        processData: !1,
        contentType: !1,
        type: "POST",
        success: function(e) {
            e = JSON.parse(e);
            document.getElementById("pop-up-background").style.display = "none";
            document.getElementById("pop-up-loading").style.display = "none";
            if (e.status === 'success'){
                window.location.href = "translate.php?id=" + e.id;
            }else{
                console.log('failed');
                document.getElementById('pop-up-error').style.display = 'block';
            }

        },
        // error: function() {
        //     document.getElementById("pop-up-background").style.display = "none", document.getElementById("pop-up-loading").style.display = "none", alert("There are one or more errors!")
        // }
    })
});